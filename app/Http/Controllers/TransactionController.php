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
        
        $query = Transaction::where('user_id', Auth::id());

        // Filter
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        $transactions = $query->orderBy('date', 'desc')->get();

        return view('riwayat', compact('transactions'));
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
