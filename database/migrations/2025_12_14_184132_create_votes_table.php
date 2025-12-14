<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nominee_id')
            ->constrained('nominees')
            ->onDelete('cascade');
            $table->foreignId('category_id')
            ->constrained('categories')
            ->index()
            ->onDelete('cascade');
            $table->foreignId('user_id')
            ->constrained('users')
            ->index()
            ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
