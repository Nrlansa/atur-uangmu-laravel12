<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Transaction extends Model
{
    
    protected $fillable = ['user_id', 'category_id', 'description', 'amount', 'type', 'category', 'date'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
