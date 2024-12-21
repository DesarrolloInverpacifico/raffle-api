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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->string('identification_number')->unique();
            $table->timestamps();
        });

        Schema::create('people_raffles', function (Blueprint $table) {
            $table->unsignedBigInteger('people_id');
            $table->unsignedBigInteger('raffle_id');
            $table->boolean('is_winner')->default(false);
            $table->boolean('is_active')->default(false);
            $table->timestamps();

            $table->primary(['people_id', 'raffle_id']);
            $table->foreign('people_id')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('raffle_id')->references('id')->on('raffles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
