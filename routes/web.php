<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Models\Transaction;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $user = Auth::user();

    // Pastikan user ada, jika tidak, arahkan ke login
    if (!$user) {
        return redirect()->route('login');
    }

    // Ambil data transaksi dengan relasi user_id (UUID) yang sudah sinkron
    $transactions = Transaction::where('user_id', $user->id)
        ->latest() // Sama dengan orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

    $totalIncome = Transaction::where('user_id', $user->id)->where('type', 'income')->sum('amount');
    $totalExpense = Transaction::where('user_id', $user->id)->where('type', 'expense')->sum('amount');
    $balance = $totalIncome - $totalExpense;

    return view('dashboard', compact('transactions', 'totalIncome', 'totalExpense', 'balance'));
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
