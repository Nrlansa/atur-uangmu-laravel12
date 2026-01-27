<?php

namespace App\Http\Controllers; 

use Illuminate\Http\Request;
use App\Services\BudgetService; 
use App\Models\Budget;

class BudgetController extends Controller
{

    public function __construct(
        protected BudgetService $service
    ) {}

    public function index(Request $request)
    {
        $month = $request->get('month', date('Y-m')); 
        $budgets = $this->service->getMonthlyMonitoring($month);
        $categories = $this->service->getAllCategories();
        return view('budget.index', compact('budgets', 'month', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount'      => 'required|numeric|min:0',
        ]);

        $validated['month'] = date('Y-m');

        $this->service->saveBudget($validated);

        return redirect()->route('budget.index')->with('success', 'Anggaran berhasil diatur!');
    }
    public function edit(Budget $budget)
    {
        $categories = $this->service->getAllCategories();
        return view('budget.edit', compact('budget', 'categories'));
    }

    public function update(Request $request, Budget $budget)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount'      => 'required|numeric|min:0',
        ]);

        $this->service->updateBudget($budget, $validated);
        return redirect()->route('budget.index')->with('success', 'Anggaran diperbarui!');
    }

    public function destroy(Budget $budget)
    {
        $this->service->deleteBudget($budget);
        return redirect()->route('budget.index')->with('success', 'Anggaran dihapus!');
    }
}