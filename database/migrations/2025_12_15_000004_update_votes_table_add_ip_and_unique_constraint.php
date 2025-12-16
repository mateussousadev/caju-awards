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
        Schema::table('votes', function (Blueprint $table) {
            // Adicionar ip_address
            $table->string('ip_address')->nullable()->after('user_id');

            // Adicionar constraint unique: um usuário só pode votar uma vez por categoria
            $table->unique(['user_id', 'category_id'], 'votes_user_category_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->dropUnique('votes_user_category_unique');
            $table->dropColumn('ip_address');
        });
    }
};
