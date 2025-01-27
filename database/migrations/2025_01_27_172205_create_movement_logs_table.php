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
        Schema::create('movement_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rover_id');
            $table->string("commands");
            $table->integer("outcome");
            $table->integer("position_x");
            $table->integer("position_y");
            $table->string("details");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movement_logs');
    }
};
