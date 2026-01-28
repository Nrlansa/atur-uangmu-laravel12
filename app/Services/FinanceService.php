<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Transaction;
use App\Services\BudgetService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class FinanceService{
    public function __construct(
        protected BudgetService $budgetService 
    ) {}

    public function getMonthlyStats($userId)
    {
        $now = now();
        $query = Transaction::where('user_id', $userId)
            ->whereMonth('date', $now->month)
            ->whereYear('date', $now->year);

        $income = (clone $query)->where('type', 'income')->sum('amount');
        $expense = (clone $query)->where('type', 'expense')->sum('amount');

        return [
            'totalIncome'  => $income, 
            'totalExpense' => $expense, 
            'balance'      => $income - $expense,
        ];
    }
    public function getChartData($userId, $rate)
    {
        $labels = [];
        $incomeData = [];
        $expenseData = [];

        $sevenDaysAgo = now()->subDays(6)->startOfDay();
        $recentStats = Transaction::where('user_id', $userId)
            ->where('date', '>=', $sevenDaysAgo)
            ->get(); //Take once from the database

        for ($i = 6; $i >= 0; $i--) {
            $dateObj = now()->subDays($i);
            $dateString = $dateObj->format('Y-m-d'); 

            $labels[] = $dateObj->format('d M');

            
            $incomeData[] = (float) $recentStats->filter(function ($trx) use ($dateString) {
                return $trx->date->format('Y-m-d') === $dateString && $trx->type === 'income';
            })->sum('amount') * $rate;

            $expenseData[] = (float) $recentStats->filter(function ($trx) use ($dateString) {
                return $trx->date->format('Y-m-d') === $dateString && $trx->type === 'expense';
            })->sum('amount') * $rate;
        }
        

        return compact('labels', 'incomeData', 'expenseData');
    }

    public function getCategoryDistribution($userId)
    {
        $transactions = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereMonth('date', now()->month)
            ->with('category')
            ->get();

        $budgets = $this->budgetService->getMonthlyMonitoring(now()->format('Y-m'))
            ->keyBy('category_id');

        $data = $transactions->groupBy('category_id')
            ->map(function ($group, $categoryId) use ($budgets) {
                $amount = (float) $group->sum('amount');
                $budget = $budgets->get($categoryId);
                $limit  = $budget ? (float) $budget->amount : 0;

            // Calculate the percentage and retrieve the status from BudgetService
            $percent = $limit > 0 ? ($amount / $limit) * 100 : 0;
                $health  = $this->budgetService->getHealthStatusByPercent($percent);

                return [
                    'category_name' => $group->first()->category->name ?? 'Lainnya',
                    'amount'        => $amount,
                    'limit'         => $limit,
                    'remaining'     => $limit - $amount,
                    'percentage'    => round($percent, 1),
                    'health'        => $health,
                     //Get the HEX color for Chart.js
                    'color'         => $this->budgetService->getHealthColor($health['bg']),
                ];
            })
            ->sortByDesc('amount')
            ->values();

        $totalRaw = (float) $transactions->sum('amount');

        return [
            'categoryLabels' => $data->pluck('category_name')->toArray(),
            // Enter color data into the main return
            'categoryColors' => $data->pluck('color')->toArray(),
            'categoryValues' => $data->map(fn($item) => $item['amount'] * Cache::get('usd_rate', 0.000064))->toArray(),
            'expenseDist'    => $data->toArray(),
            'totalAmount'    => $totalRaw,
        ];
    }
}