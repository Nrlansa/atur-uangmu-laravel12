<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $categories = \App\Models\Category::all();

        $transactions = \App\Models\Transaction::where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        $totalIncome = \App\Models\Transaction::where('user_id', $user->id)->where('type', 'income')->sum('amount');
        $totalExpense = \App\Models\Transaction::where('user_id', $user->id)->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        return view('dashboard', compact('transactions', 'totalIncome', 'totalExpense', 'balance', 'categories'));
    }
}
