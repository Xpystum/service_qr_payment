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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->timestamps();

            $table->foreignId('owner_id')
                ->nullable()
                ->constrained('users');

            $table->string('name');
            $table->string('address');
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('type');
            $table->text('description')->nullable();
            $table->string('industry')->nullable();
            $table->string('founded_date')->nullable();
            $table->string('inn', 12)->unique();
            $table->string('kpp' , 9)->nullable();
            $table->string('registration_number', 13)->nullable();
            $table->string('registration_number_individual', 15)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
