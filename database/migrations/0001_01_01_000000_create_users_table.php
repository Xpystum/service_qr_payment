<?php

use App\Modules\User\Enums\RoleUserEnum;
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
        Schema::create('users', function (Blueprint $table) {

            $table->id();
            $table->uuid()->unique();

            $table->string('phone')->nullable()->unique();
            $table->string('email')->nullable()->unique();

            $table->string('first_name')->nullable()->comment('Имя');
            $table->string('last_name')->nullable()->comment('Фамилия');
            $table->string('father_name')->nullable()->comment('Отчество');

            $table->enum('role', [RoleUserEnum::admin->value, RoleUserEnum::manager->value, RoleUserEnum::cashier->value])->default(RoleUserEnum::admin->value);

            $table->timestamp('email_confirmed_at')->nullable();
            $table->timestamp('phone_confirmed_at')->nullable();

            $table->string('password');
            $table->rememberToken(); //? нужен ли при JWT

            $table->boolean('active')->default(true)->comment('Для блокировки пользователя.');
            $table->boolean('auth')->default(false)->comment('Прошёл ли пользователь валидацию.');


            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
