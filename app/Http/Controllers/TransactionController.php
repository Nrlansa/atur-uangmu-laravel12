<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\FinanceService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTransactionRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TransactionController extends Controller
{
    public function __construct(protected FinanceService $finance) {}

    public function index(Request $request): View
    {
        $month = $request->query('month', now()->month);
        $year = $request->query('year', now()->year);

        $transactions = Transaction::with('category')
            ->where('user_id', Auth::id())
            ->when($request->type, fn($query, $type) => $query->where('type', $type))
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date', 'desc')
            ->paginate(10)
            ->withQueryString();

        $currency = session('currency', 'IDR');

        return view('riwayat', compact('transactions', 'month', 'year', 'currency'));
    }

    public function store(StoreTransactionRequest $request): RedirectResponse
    {
        try {
            // The validated data has been entered into the service.
            $this->finance->storeTransaction($request->validated());

            return redirect()->back()->with('success', __('messages.transaction_success'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('messages.system_error'));
        }
    }

    public function destroy(Transaction $transaction): RedirectResponse
    {
        abort_if($transaction->user_id !== Auth::id(), 403);

        $transaction->delete();

        return redirect()->back()->with('success', __('messages.delete_success'));
    }
}
