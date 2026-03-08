<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExportReportRequest;
use App\Models\Transaction;
use App\Services\ExportService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller
{
  
    public function __construct(
        protected ExportService $exportService
    ) {}

    /**
     * Displaying the report filter form page.
     */
    public function index(): View
    {
       
        $recentTransactions = Transaction::with('category')
            ->where('user_id', Auth::id())
            ->latest()
            ->take(3)
            ->get();

        return view('report.index', [
            'recentTransactions' => $recentTransactions,
            'currency'           => session('currency', 'IDR')
        ]);
    }

    /**
     * Handling the PDF download process.
     */
    public function download(ExportReportRequest $request): Response
    {
        // Validation to prevent crashes
        $validated = $request->validate([
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        // Take currency from one session
        $currency = session('currency', 'IDR');

        //Delegate to Service with Carbon Object
        $pdf = $this->exportService->generateFinancePDF(
            userId: Auth::id(),
            startDate: $request->start_date, 
            endDate: $request->end_date,    
            currency: session('currency', 'IDR')
        );

        // File Name Dynamization Based on Language
        $prefix = ($currency === 'USD') ? 'Financial_Report' : 'Laporan_Keuangan';
        $fileName = sprintf('%s_%s.pdf', $prefix, now()->format('d_M_Y'));

        return $pdf->download($fileName);
    }
}
