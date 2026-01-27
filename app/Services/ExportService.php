<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Facades\App;

class ExportService
{
    public function generateFinancePDF($userId, $startDate, $endDate, $currency)
    {
        $transactions = Transaction::with('category')
            ->where('user_id', $userId)
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');

        $data = [
            'transactions' => $transactions,
            'totalIncome'  => $totalIncome,
            'totalExpense' => $totalExpense,
            'startDate'    => $startDate, 
            'endDate'      => $endDate,   
            'currency'     => $currency
        ];

        $pdf = App::make('dompdf.wrapper');
        return $pdf->loadView('report.finance_pdf', $data)
                    ->setPaper('a4', 'portrait');
    }
}
