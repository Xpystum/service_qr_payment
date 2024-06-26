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
        Schema::table('payments', function (Blueprint $table) {
            
            //полиморфное отношение
            $table->morphs('payple');

            $table->foreignId('method_id')->constrained('payment_methods')->comment('Валюта провайдера'); //способ оплаты у платежа QIWI, YOUCASSA, PAYPAL, BITCOIN

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            //
        });
    }
};
