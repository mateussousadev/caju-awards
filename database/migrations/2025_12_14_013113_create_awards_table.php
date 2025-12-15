<?php

use App\AwardStatus;
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
        Schema::create('awards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('year')->index();
            $table->date('voting_start_date');
            $table->date('voting_end_date');
            $table->enum('status', AwardStatus::all())->default(AwardStatus::DRAFT->value)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['year', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('awards');
    }
};
