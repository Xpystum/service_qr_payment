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
        Schema::create('transactions', function (Blueprint $table) {

            $table->id();
            $table->uuid('uuid')->unique();
            $table->timestamps();

            $table->string('status'); //pending, completed, cancelled

            $table->foreignId('driver_currency_id')->constrained('currencies')->comment('Валюта провайдера');

            $table->decimal('amount', 12, 2)->comment('сумма заказов');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
