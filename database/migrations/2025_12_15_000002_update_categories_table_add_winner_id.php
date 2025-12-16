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
        Schema::table('categories', function (Blueprint $table) {
            // Adicionar winner_id (foreignId nullable para nominees)
            $table->foreignId('winner_id')
                ->nullable()
                ->after('type')
                ->constrained('nominees')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['winner_id']);
            $table->dropColumn('winner_id');
        });
    }
};
