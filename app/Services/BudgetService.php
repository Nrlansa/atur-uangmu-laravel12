<?php

namespace App\Services;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class BudgetService
{
    public function getMonthlyMonitoring(string $month)
    {
        return Budget::with('category')
            ->where('user_id', Auth::id())
            ->where('month', $month)
            ->withTotalSpent($month)
            ->get();
    }

    public function getAllCategories()
    {
        return Category::all();
    }

    public function saveBudget(array $data)
    {
        return Budget::updateOrCreate(
            [
                'user_id'     => Auth::id(),
                'category_id' => $data['category_id'],
                'month'       => $data['month'] ?? now()->format('Y-m'),
            ],
            ['amount' => $data['amount']]
        );
    }
    public function updateBudget(Budget $budget, array $data): bool
    {
        return $budget->update([
            'user_id'     => Auth::id(),
            'category_id' => $data['category_id'],
            'amount'      => $data['amount'],
        ]);
    }

    public function deleteBudget(Budget $budget): bool
    {
        return $budget->delete();
    }
}
