<?php

namespace App\Services;


class QuickMessengerService{
    public function formatFinanceQuickMessenger($data)
    {
        $message = "📊 *". __('messages.title_QM') ."* 📊\n";
        $message .= "". __('messages.period') .": _{$data['startDate']} s/d {$data['endDate']}_\n";
        $message .= "------------------------------------------\n\n";

        $message .= "💰 *". __('messages.income_QM') .":* {$data['currency']} " . number_format($data['totalIncome'], 0, ',', '.') . "\n";
        $message .= "💸 *".__('messages.expense_QM') .":* {$data['currency']} " . number_format($data['totalExpense'], 0, ',', '.') . "\n";
        $message .= "📈 *".__('messages.balance_QM') .":* {$data['currency']} " . number_format($data['totalIncome'] - $data['totalExpense'], 0, ',', '.') . "\n\n";

        if (!empty($data['expenseDist'])) {
            $message .= "📂 *".__('messages.spending_QM') .":* \n";
            $tops = array_slice($data['expenseDist'], 0, 3);
            foreach ($tops as $dist) {
                $message .= "• {$dist['category_name']}: " . number_format($dist['amount'], 0, ',', '.') . "\n";
            }
        }

        $message .= "\n------------------------------------------\n";
        $message .= "✅ ".__('messages.title_bottomQM') ." ";

        return $message;
    }
}