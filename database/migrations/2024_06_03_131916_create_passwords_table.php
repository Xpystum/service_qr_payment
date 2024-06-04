<?php

use App\Modules\User\Enums\Password\PasswordStatusEnum;
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
        Schema::create('passwords', function (Blueprint $table) {

            $table->id()->from(1001);
            $table->uuid('uuid')->unique();
            $table->string('code')->index()->nullable();
            $table->foreignId('notification_id')->nullable()->constrained('notification')->nullable();
            $table->timestamps();

            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('status')->default(PasswordStatusEnum::pending->value);
            $table->ipAddress('ip');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passwords');
    }
};
