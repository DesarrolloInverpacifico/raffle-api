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
        Schema::create('raffle_participants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('identification_number')->nullable();
            $table->boolean('is_winner')->default(false);
            $table->timestamp('won_at')->nullable();
            $table->unsignedBigInteger('raffle_id')->nullable();
            // $table->unsignedBigInteger('raffle_prize_id')->nullable();
            $table->timestamps();

            $table->foreign('raffle_id')->references('id')->on('raffles')->onDelete('cascade');
            // $table->foreign('raffle_prize_id')->references('id')->on('raffle_prizes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raffle_participants');
    }
};
