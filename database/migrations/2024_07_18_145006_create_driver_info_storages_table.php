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
        Schema::create('driver_info_storages', function (Blueprint $table) {

            $table->id();

            $table->string('type_name', 100); //К какому пользователю указаны заданные параметры
            $table->foreignId('type_id')->constrained('payment_methods'); //Привязка к таблице payment_methods

            $table->string('parametr_name')->comment('Название параметра'); //название параметра к примеру у ЮМАНИ -> apikey1, apikey2
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_info_storages');
    }
};
