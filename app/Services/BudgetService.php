<?php

namespace App\Services;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class BudgetService
{
    public function getMonthlyMonitoring(string $month)
    {
        return Budget::with('category')
            ->where('user_id', Auth::id())
            ->where('month', $month)
            ->withTotalSpent($month, Auth::id()) 
            ->get()
            ->map(function ($budget) {
                $spent = (float) ($budget->total_spent ?? 0);
                $limit = (float) $budget->amount;
                $percent = $limit > 0 ? ($spent / $limit) * 100 : 0;
                $budget->total_spent = (float) ($budget->total_spent ?? 0);
                $budget->percentage = round($percent, 1);
                $budget->health = $this->calculateHealthStatus($percent);

                return $budget;
            });
    }

    private function calculateHealthStatus(float $percent): array
    {
        return match (true) {
            $percent < 70  => [
                'bg'       => 'bg-emerald-500',
                'light_bg' => 'bg-emerald-50', 
                'text'     => 'text-emerald-600',
                'label'    => __('messages.safe')
            ],
            $percent <= 90 => [
                'bg'       => 'bg-amber-500',
                'light_bg' => 'bg-amber-50',  
                'text'     => 'text-amber-600',
                'label'    => __('messages.warning')
            ],
            default => [
                'bg'       => 'bg-rose-500',
                'light_bg' => 'bg-rose-50',   
                'text'     => 'text-rose-600',
                'label'    => __('messages.danger')
            ],
        };
    }

    /**
     * Public Bridge to calculate health status from outside this service.
     */
    public function getHealthStatusByPercent(float $percent): array
    {
        // call method private 
        return $this->calculateHealthStatus($percent);
    }

    public function getHealthColor(string $tailwindClass): string
    {
        // Mapping color to Chart.js (Hex Code)
        return match ($tailwindClass) {
            'bg-emerald-500' => '#10b981',
            'bg-amber-500'   => '#f59e0b',
            'bg-rose-500'    => '#f43f5e',
            default          => '#94a3b8',
        };
    }

    public function getAllCategories()
    {
        return Category::all();
    }

    public function saveBudget(array $data)
    {
        return Budget::updateOrCreate(
            [
                'user_id'     => Auth::id(),
                'category_id' => $data['category_id'],
                'month'       => $data['month'] ?? now()->format('Y-m'),
            ],
            ['amount' => $data['amount']]
        );
    }
    public function updateBudget(Budget $budget, array $data): bool
    {
        return $budget->update([
            'amount'      => $data['amount'],
        ]);
    }

    public function deleteBudget(Budget $budget): bool
    {
        return $budget->delete();
    }
}
