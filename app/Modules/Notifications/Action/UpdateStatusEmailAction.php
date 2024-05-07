<?php

namespace App\Modules\Notifications\Action;

use App\Modules\Notifications\Enums\ActiveStatusEnum;
use App\Modules\Notifications\Models\Email;
use Exception;
use Illuminate\Support\Facades\Log;

class UpdateStatusEmailAction
{
    public static function run(Email $email, ActiveStatusEnum $status) : bool
    {
        try {

            $email = $email->query()->update([

                'status' => $status->value

            ]);

            return ($email > 0) ? true : false;

        } catch (Exception $exception) {

            Log::error("Произошла ошибка при обновлении модели: " . $exception->getMessage());

            return false;

        }

    }

}
