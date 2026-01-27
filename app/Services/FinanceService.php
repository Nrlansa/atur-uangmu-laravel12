<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class FinanceService{
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

            // Data processing
            $incomeData[] = $recentStats->where('date', $dateString)->where('type', 'income')->sum('amount') * $rate;
            $expenseData[] = $recentStats->where('date', $dateString)->where('type', 'expense')->sum('amount') * $rate;
        }

        return compact('labels', 'incomeData', 'expenseData');
    }
}