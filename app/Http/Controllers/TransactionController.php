<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            DB::transaction(function () use ($request) {
                Transaction::create([
                    'user_id'     => Auth::id(),
                    'category_id' => $request->category_id,
                    'description' => $request->description,
                    'amount'      => $request->amount,
                    'type'        => $request->type,
                    'date'        => $request->date,
                ]);
            });

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
        $transaction->delete();
        return redirect()->back()->with('success', 'Transaksi berhasil dihapus!');
    }
}
