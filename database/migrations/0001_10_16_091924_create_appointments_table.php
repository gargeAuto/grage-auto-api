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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table
                ->foreignId('engineer_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');
            $table->string("service")->nullable();
            $table->dateTime("selectedStart");
            $table->decimal("total_price")->nullable();
            $table->decimal("new_price")->nullable();
            $table->longText("comments")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
