<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Transaction extends Model
{
    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2', 
    ];
    protected $fillable = ['user_id', 'category_id', 'description', 'amount', 'type', 'date', 'exchange_rate'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
