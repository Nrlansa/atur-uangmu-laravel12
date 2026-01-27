<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0',
            'type'        => 'required|in:income,expense',
            'category_id' => 'required|exists:categories,id', 
            'date'        => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => __('messages.validation_category_required'),
            'amount.min'           => __('messages.validation_amount_min'),
        ];
    }
}
