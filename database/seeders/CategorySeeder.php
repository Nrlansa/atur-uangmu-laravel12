<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Salary', 'icon' => 'fa-wallet'],
            ['name' => 'Food & Beverage', 'icon' => 'fa-utensils'],
            ['name' => 'Transportation', 'icon' => 'fa-car'],
            ['name' => 'Shopping', 'icon' => 'fa-bag-shopping'],
            ['name' => 'Entertainment', 'icon' => 'fa-gamepad'],
            ['name' => 'Medical', 'icon' => 'fa-heart-pulse'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
