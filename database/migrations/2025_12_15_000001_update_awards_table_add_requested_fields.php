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
        Schema::table('awards', function (Blueprint $table) {
            // Adicionar description
            $table->text('description')->nullable()->after('name');

            // Renomear voting_start_date para voting_start_at e mudar para datetime
            $table->renameColumn('voting_start_date', 'voting_start_at');
            $table->renameColumn('voting_end_date', 'voting_end_at');

            // Adicionar is_active
            $table->boolean('is_active')->default(true)->after('voting_end_at');
        });

        // Alterar tipo das colunas para datetime
        Schema::table('awards', function (Blueprint $table) {
            $table->dateTime('voting_start_at')->nullable()->change();
            $table->dateTime('voting_end_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('awards', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('is_active');

            $table->renameColumn('voting_start_at', 'voting_start_date');
            $table->renameColumn('voting_end_at', 'voting_end_date');
        });

        Schema::table('awards', function (Blueprint $table) {
            $table->date('voting_start_date')->change();
            $table->date('voting_end_date')->change();
        });
    }
};
