<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use App\Services\FinanceService;
use App\Services\CurrencyService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function __construct(
        protected CurrencyService $currency,
        protected FinanceService $finance
    ) {}

    public function index()
    {
        $user = Auth::user();
        $currency = session('currency', 'IDR');

        $this->currency->updateExchangeRate();

        $stats = $this->finance->getMonthlyStats($user->id, $currency);
        $chart = $this->finance->getChartData($user->id, $currency);
        $categoryStats = $this->finance->getCategoryDistribution($user->id, $currency);

        return view('dashboard', array_merge([
            'currency'     => $currency,
            'transactions' => Transaction::where('user_id', $user->id)
                ->with('category')
                ->latest()
                ->limit(5)
                ->get(),
            'categories'   => Category::all(),
        ], $stats, $chart, $categoryStats));
    }
}