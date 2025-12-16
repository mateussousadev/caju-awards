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
        Schema::table('nominees', function (Blueprint $table) {
            // Adicionar campos solicitados
            $table->string('name')->after('user_id');
            $table->text('description')->nullable()->after('name');
            $table->string('photo')->nullable()->after('description');

            // Tornar campos quantitativos nullable (já que agora não são obrigatórios para todos os tipos)
            $table->string('quantitative_description')->nullable()->change();
            $table->decimal('quantitative_value', 10, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nominees', function (Blueprint $table) {
            $table->dropColumn(['name', 'description', 'photo']);

            $table->string('quantitative_description')->nullable(false)->change();
            $table->decimal('quantitative_value', 10, 2)->nullable(false)->change();
        });
    }
};
