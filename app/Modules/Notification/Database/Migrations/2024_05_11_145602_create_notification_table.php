<?php

use App\Modules\Notification\Enums\ActiveStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {

            $table->id();
            $table->uuid('uuid')->unique();
            $table->timestamps();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->foreignId('method_id');
            $table->foreign('method_id')->references('id')->on('notification_methods');


            $table->string('status')->default(ActiveStatusEnum::pending->value);
            $table->string('value')->nullable();
            $table->string('code')->index();
            $table->unsignedTinyInteger('quantity')->default(5)->comment('Количество оставшихся попыток');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
