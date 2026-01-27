<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Budget extends Model
{
    protected $fillable = ['user_id', 'category_id', 'amount', 'month'];

    /**
     * Relationship ke Category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relationship ke User (UUID)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    
    public function scopeWithTotalSpent(Builder $query, string $month): void
    {
        $query->addSelect([
            'total_spent' => Transaction::selectRaw('SUM(amount)')
                ->whereColumn('category_id', 'budgets.category_id')
                ->where('user_id', Auth::id()) 
                ->where(DB::raw("DATE_FORMAT(date, '%Y-%m')"), $month)
        ]);
    }

    protected function healthStatus(): Attribute
    {
        return Attribute::get(function () {
            $spent = $this->total_spent ?? 0;
            $percent = $this->amount > 0 ? ($spent / $this->amount) * 100 : 0;

            return match (true) {
                $percent < 70  => [
                    'bg' => 'bg-emerald-500',
                    'light_bg' => 'bg-emerald-50',
                    'text' => 'text-emerald-600',
                    'label' => __('messages.safe')
                ],
                $percent <= 90 => [
                    'bg' => 'bg-amber-500',
                    'light_bg' => 'bg-amber-50',
                    'text' => 'text-amber-600',
                    'label' => __('messages.warning')
                ],
                default => [
                    'bg' => 'bg-rose-500',
                    'light_bg' => 'bg-rose-50',
                    'text' => 'text-rose-600',
                    'label' => __('messages.danger')
                ],
            };
        });
    }
}
