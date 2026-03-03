<?php

namespace App\Services;

use App\Models\Transaction;
use App\Services\BudgetService;
use App\Services\FinanceService;
use Illuminate\Support\Facades\App;

class ExportService
{
    public function __construct(
        protected FinanceService $financeService, // Handling category & budget data
        protected BudgetService $budgetService    // Handling budget monitoring
    ) {}

    public function generateFinancePDF($userId, $startDate, $endDate, $currency)
    {
        $transactions = Transaction::with('category')
            ->where('user_id', $userId)
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');

        $categoryDist = $this->financeService->getCategoryDistribution(
            $userId,
            $currency,
            $startDate,
            $endDate
        );

        $data = [
            'transactions' => $transactions,
            'totalIncome'  => $totalIncome,
            'totalExpense' => $totalExpense,
            'expenseDist'  => $categoryDist['expenseDist'] ?? [],
            'startDate'    => $startDate,
            'endDate'      => $endDate,
            'currency'     => $currency
        ];

        $pdf = App::make('dompdf.wrapper');
        return $pdf->loadView('report.finance_pdf', $data)
            ->setPaper('a4', 'portrait');
    }
}
