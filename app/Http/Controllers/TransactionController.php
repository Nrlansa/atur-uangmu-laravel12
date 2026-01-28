<?php

namespace App\Http\Controllers;

use id;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTransactionRequest;

class TransactionController extends Controller
{

    public function index(Request $request)
    {
        // take the filter input or set the default to the current month/year
        $month = $request->query('month', now()->month);
        $year = $request->query('year', now()->year);

        // query builder with Eager Loading
        $transactions = Transaction::with('category') 
            ->where('user_id', Auth::id())
            ->when($request->type, function ($query, $type) {
                return $query->where('type', $type);
            })
            // Month & year filter 
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date', 'desc')
            ->paginate(10) // 
            ->withQueryString();

        // Send filter data back to view 
        return view('riwayat', compact('transactions', 'month', 'year'));
    }
   
    public function create()
    {
        //
    }

    public function store(StoreTransactionRequest $request)
    {
        try {
            $data = $request->validated();
            $data['user_id']= Auth::id();
            Transaction::create($data);
            return redirect()->back()->with('success', 'Transaction recorded successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to save transaction.');
        }
    }
    
    public function show(string $id)
    {
        //
    }

    
    public function edit(string $id)
    {
        //
    }

    
    public function update(Request $request, string $id)
    {
        //
    }

    
    public function destroy(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $transaction->delete();
        return redirect()->back()->with('success', 'Transaksi berhasil dihapus!');
    }
}
