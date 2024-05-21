<?php

use App\Modules\Notification\Enums\ActiveStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification', function (Blueprint $table) {

            $table->id();
            $table->uuid('uuid')->unique();
            $table->timestamps();

            $table->foreignId('user_id')->constrained();

            $table->foreignId('method_id');
            $table->foreign('method_id')->references('id')->on('notification_method');



            $table->string('status')->default(ActiveStatusEnum::pending->value);
            $table->string('code');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification');
    }
};
