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
        Schema::create('payments', function (Blueprint $table) {
            $table->id()->from(1001);


            $table->uuid('uuid')->unique();

            $table->timestamps();

            // $table->timestamps('expires_at'); // когда истекает платеж


            $table->string('status');

            $table->decimal('amount', 12, 2); // сумма

            $table->string('driver')->nullable(); // для удобности (но нарушается нормализация)

            $table->string('driver_payment_id')->nullable()->comment('id платежа у провайдера на хосте'); // для удобности (но нарушается нормализация)

            $table->decimal('driver_amount', 12, 2)->nullable()->comment('сумма провайдера'); // сумма

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
