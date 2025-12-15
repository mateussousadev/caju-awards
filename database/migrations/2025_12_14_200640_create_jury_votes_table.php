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
        Schema::create('jury_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jury_member_id')
            ->constrained('jury_members')
            ->onDelete('cascade');
            $table->foreignId('nominee_id')
            ->constrained('nominees')
            ->onDelete('cascade');
            $table->foreignId('category_id')
            ->constrained('categories')
            ->onDelete('cascade');
            $table->integer('score');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jury_votes');
    }
};
