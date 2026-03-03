<?php

namespace App\Services;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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
    public function getBudgetsByRange(?string $startDate, ?string $endDate)
    {
        $months = [];
        if ($startDate && $endDate) {
            $start = new \DateTime($startDate);
            $end = new \DateTime($endDate);

            $start->modify('first day of this month');
            $end->modify('first day of this month');

            while ($start <= $end) {
                $months[] = $start->format('Y-m');
                $start->modify('+1 month');
            }
        } else {
            $months[] = now()->format('Y-m');
        }

        return Budget::with('category')
            ->where('user_id', Auth::id())
            ->whereIn('month', $months)
            ->get();
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
        // Get the current exchange rate to be locked in
        $currentRate = Cache::get('usd_rate', 0.0000641);

        return Budget::updateOrCreate(
            [
                'user_id'     => Auth::id(),
                'category_id' => $data['category_id'],
                'month'       => $data['month'] ?? now()->format('Y-m'),
            ],
            [
                'amount'        => $data['amount'],
                'exchange_rate' => $currentRate
            ]
        );
    }

    public function updateBudget(Budget $budget, array $data): bool
    {
        // When updating the nominal value, the exchange rate must also be refreshed to the latest rate.
        return $budget->update([
            'amount'        => $data['amount'],
            //if unable to obtain API, use 0.0000641 as the DEFAULT USDRATE API
            'exchange_rate' => Cache::get('usd_rate', 0.0000641),
        ]);
    }
    public function deleteBudget(Budget $budget): bool
    {
        return $budget->delete();
    }
}
