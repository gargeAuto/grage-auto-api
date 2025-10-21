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
        Schema::create('garage', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("adress");
            $table->integer("postal_code");
            $table->string("city");
            $table->string("email")->unique();
            $table->integer("engineer_quantity");
            $table->decimal("service_price");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('garage');
    }
};
