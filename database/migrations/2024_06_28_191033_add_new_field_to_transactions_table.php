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
        Schema::table('transactions', function (Blueprint $table) {



            $table->string('driver_currency_id')->nullable()->comment('Валюта провайдера');
            $table->foreign('driver_currency_id')->references('id')->on('currencies');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
           $table->dropForeign('transactions_driver_currency_id_foreign');
            $table->dropColumn('driver_currency_id');
        });
    }
};
