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
        Schema::create('driver_infos', function (Blueprint $table) {

            $table->id();
            $table->uuid('uuid')->unique();

            $table->string('name_type')->comment('Сделано для удобного получение имени Type: "Метода Оплаты" ');//нарушение нормального состояние (сделано для удобности получение имени типа метода оплаты payment_methods)
            $table->foreignId('type_id')->constrained('payment_methods');//Привязка к таблице payment_methods

            $table->string('parametr')->comment('название параметра к примеру ApiKey, Parament, password'); //название параметра к примеру ApiKey, Parament, password и т.д (у каждых платежек свои параметры)

            $table->foreignId('owner_id')->constrained('users'); //К какому пользователю указаны заданные параметры

            $table->string('value')->comment('Значение параметров'); //Значение параметров

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_infos');
    }
};
