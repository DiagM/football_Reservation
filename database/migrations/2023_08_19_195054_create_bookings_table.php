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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->dateTime('reservation_date');
            $table->time('reservation_time');
            $table->dateTime('reservation_date_end');
            $table->time('reservation_time_end');

            $table->index('stadium_id');
            $table->foreignId('stadium_id')->references('id')->on('stadiums')->onDelete(('cascade'));
            $table->index('client_id');
            $table->foreignId('client_id')->references('id')->on('clients')->onDelete(('cascade'));
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
