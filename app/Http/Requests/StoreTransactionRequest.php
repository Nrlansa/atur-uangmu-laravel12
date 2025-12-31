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
    
}
