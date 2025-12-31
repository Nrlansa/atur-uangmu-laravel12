<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: Food, Transport, Salary
            $table->string('icon')->nullable(); // Opsional: icon FontAwesome
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
