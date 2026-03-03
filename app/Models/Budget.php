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
    protected $fillable = ['user_id', 'category_id', 'amount', 'month', 'exchange_rate'];

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
}
