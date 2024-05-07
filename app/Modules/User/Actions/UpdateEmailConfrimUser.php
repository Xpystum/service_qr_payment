<?php

namespace App\Modules\User\Actions;

use App\Modules\User\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

class UpdateEmailConfrimUser
{
    public static function run(User $user): bool
    {
        try {

            // * обновляет по серверному времени
            $status = $user->query()->update([
                'email_confirmed_at' => now(),
            ]);

            //что бы сразу акутальные данные отправлилсь в ответ api
            $user->refresh();

            return ($status > 0) ? true : false;

        } catch (Exception $e) {

            Log::error("Произошла ошибка при обновлении модели: " . $e->getMessage());

            return false;
        }

    }

}
