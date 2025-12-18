<?php

use App\CategoryType;
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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('award_id')
            ->constrained('awards')
            ->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->enum('type', CategoryType::all())->default(CategoryType::PUBLIC_VOTE);
            $table->integer('public_vote_weight')->default(0);
            $table->integer('quantitative_weight')->default(0);
            $table->integer('jury_weight')->default(0);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
