<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\ExportService;
use Illuminate\Support\Facades\Auth;
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
    public function download(Request $request): Response
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
            startDate: \Carbon\Carbon::parse($request->start_date),
            endDate: \Carbon\Carbon::parse($request->end_date),
            currency: $currency
        );

        // File Name Dynamization Based on Language
        $prefix = ($currency === 'USD') ? 'Financial_Report' : 'Laporan_Keuangan';
        $fileName = sprintf('%s_%s.pdf', $prefix, now()->format('d_M_Y'));

        return $pdf->download($fileName);
    }
}
