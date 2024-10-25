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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('team_name');
            $table->string('reference');
            $table->string('phone_number');
            $table->double('price');
            $table->integer('session_number');
            $table->index('subscription_id');
            $table->foreignId('subscription_id')->references('id')->on('subscriptions')->onDelete(('cascade'));
            $table->date('start_subs');
            $table->date('end_subs');
            $table->boolean('reservation_confirmed')->default(false); // Add this line
            $table->index('created_by');
            $table->foreignId('created_by')->references('id')->on('users')->onDelete(('cascade'));
            $table->index('edited_by');
            $table->foreignId('edited_by')->references('id')->on('users')->onDelete(('cascade'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
