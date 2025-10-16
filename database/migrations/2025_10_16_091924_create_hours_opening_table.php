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
        Schema::create('hours_opening', function (Blueprint $table) {
            $table->id();
            $table->garage();
            $table->start_morning_date();
            $table->end_morning_date();
            $table->start_afternoon_date();
            $table->end_afternoon_date();
            $table->close();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hours_opening');
    }
};
