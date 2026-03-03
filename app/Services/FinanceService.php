<?php

namespace App\Services;

use App\Models\Transaction;
use App\Services\BudgetService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class FinanceService{
    public function __construct(
        protected BudgetService $budgetService,
        protected CurrencyService $currencyService
    ) {}

    public function storeTransaction(array $data)
    {
        // Get the rate from the service (automatically retrieved from cache/API)
        $rate = $this->currencyService->updateExchangeRate();

        return Transaction::create([
            'user_id'       => Auth::id(),
            'category_id'   => $data['category_id'],
            'amount'        => $data['amount'],
            'exchange_rate' => $rate,
            'type'          => $data['type'],
            'description'   => $data['description'],
            'date'          => $data['date'] ?? now(),
        ]);
    }

    public function getMonthlyStats($userId, $currency = 'IDR')
    {
        $transactions = Transaction::where('user_id', $userId)
            ->whereMonth('date', now()->month)
            ->get();

        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');

        return [
            'totalIncome' => (float) $totalIncome,
            'totalExpense' => (float) $totalExpense,
            'balance' => (float) ($totalIncome - $totalExpense)
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


            $incomeData[] = $recentStats->filter(function ($trx) use ($dateString) {
                return $trx->date->format('Y-m-d') === $dateString && $trx->type === 'income';
            })->sum(fn($trx) => (float)$trx->amount * (float)($trx->exchange_rate ?? 1));

            $expenseData[] = $recentStats->filter(function ($trx) use ($dateString) {
                return $trx->date->format('Y-m-d') === $dateString && $trx->type === 'expense';
            })->sum(fn($trx) => (float)$trx->amount * (float)($trx->exchange_rate ?? 1));
        }
        

        return compact('labels', 'incomeData', 'expenseData');
    }

    public function getCategoryDistribution($userId, $currency = 'IDR', $startDate = null, $endDate = null)
    {
        // Take the exchange rate once at the beginning as a fallback for old data whose exchange_rate is still null
        // If you fail to obtain the API, use 0.0000641 as the DEFAULT USD RATE API.
        $currentRate = (float) Cache::get('usd_rate', 0.0000641);

        $query = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->with('category');

        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        } else {
            $query->whereMonth('date', now()->month);
        }

        $transactions = $query->get();

        $budgetsRaw = $this->budgetService->getBudgetsByRange($startDate, $endDate);

        $budgets = $budgetsRaw->groupBy('category_id')->map(function ($group) {
            $merged = $group->first();
            $merged->amount = $group->sum('amount');
            return $merged;
        });

        $data = $budgets->map(function ($budget) use ($transactions, $currency, $currentRate) {
            // Calculate Expenses by Category
            $amount = $transactions->where('category_id', $budget->category_id)->sum(
                fn($trx) => $currency === 'USD'
                    ? (float)$trx->amount * (float)($trx->exchange_rate ?? $currentRate)
                    : (float)$trx->amount
            );

            $limitRaw = (float) $budget->amount;

            // Use the exchange_rate from the budget database; if null, use currentRate (fallback)
            $budgetRate = (float) ($budget->exchange_rate ?? $currentRate);

            // Convert Budget Limit to USD using the locked rate
            $limit = $currency === 'USD' ? $limitRaw * $budgetRate : $limitRaw;

            $percent = $limit > 0 ? ($amount / $limit) * 100 : 0;
            $health  = $this->budgetService->getHealthStatusByPercent($percent);

            return [
                'category_name' => $budget->category->name ?? 'Lainnya',
                'amount'        => (float)$amount,
                'limit'         => (float)$limit,
                'remaining'     => (float)($limit - $amount),
                'percentage'    => round($percent, 1),
                'health'        => $health,
                'color'         => $this->budgetService->getHealthColor($health['bg']),
                'rate'          => $currency === 'USD' ? 1 : null,
            ];
        })
            ->sortByDesc('amount')
            ->values();

        $totalRaw = $data->sum('amount');

        return [
            'categoryLabels' => $data->pluck('category_name')->toArray(),
            'categoryColors' => $data->pluck('color')->toArray(),
            'categoryValues' => $data->pluck('amount')->toArray(),
            'expenseDist'    => $data->toArray(),
            'totalAmount'    => (float)$totalRaw,
        ];
    }
}