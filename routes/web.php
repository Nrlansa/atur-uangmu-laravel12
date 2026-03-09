<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    TransactionController,
    BudgetController,
    ReportController,
    QuickMessengerController,
    ProfileController,
    LocaleController,
    CurrencyController
};

// --- Public Routes ---
Route::permanentRedirect('/', '/login');
Route::get('currency/{currency}', [CurrencyController::class, 'switch'])->name('currency.switch');
Route::get('lang/{locale}', [LocaleController::class, 'switch'])->name('lang.switch');

// --- Authenticated Routes ---
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Transactions 
    Route::controller(TransactionController::class)->prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', 'index')->name('index'); // Pengganti /riwayat
        Route::post('/', 'store')->name('store');
        Route::delete('/{transaction}', 'destroy')->name('destroy');
    });

    // Budget
    Route::resource('budget', BudgetController::class);

    // Reports
    Route::controller(ReportController::class)->prefix('report')->name('report.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/download', 'download')->name('download');
    });

    // WhatsApp
    Route::controller(QuickMessengerController::class)->prefix('whatsapp')->name('whatsapp.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/send', 'send')->name('send');
    });

    // Profile
    Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });
});

require __DIR__ . '/auth.php';
