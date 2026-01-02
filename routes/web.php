<?php

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('currency/{currency}', [CurrencyController::class, 'switch'])->name('currency.switch');
Route::get('lang/{locale}', [LocaleController::class, 'switch'])->name('lang.switch');
Route::get('/dashboard', function () {
    $user = Auth::user();
    $categories = Category::all();
   
    if (!$user) {
        return redirect()->route('login');
    }

    $transactions = Transaction::where('user_id', $user->id)
        ->latest() 
        ->limit(5)
        ->get();

    $totalIncome = Transaction::where('user_id', $user->id)->where('type', 'income')->sum('amount');
    $totalExpense = Transaction::where('user_id', $user->id)->where('type', 'expense')->sum('amount');
    $balance = $totalIncome - $totalExpense;

    return view('dashboard', compact('transactions', 'totalIncome', 'totalExpense', 'balance', 'categories'));
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/transactions/store', [TransactionController::class, 'store'])->name('transactions.store');
    Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    Route::get('/riwayat', [TransactionController::class, 'index'])->name('riwayat.index');
    //Route::get('/laporan', [laporanController::class, 'index'])->name('riwayat.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
