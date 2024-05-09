<?php

namespace App\Modules\Notifications\Action;

use App\Modules\Notifications\Models\Email;
use Exception;
use Illuminate\Support\Facades\Log;

use function App\Helpers\code;

class UpdateCodeAction
{
    public static function run(Email $email) : bool
    {

        try {

            $status = $email?->query()?->update([

                'code' => code(),

            ]);

            return ($status > 0) ? true : false;

        } catch (Exception $exception) {

            Log::error("Произошла ошибка при обновлении модели: " . $exception->getMessage());

            return false;

        }

    }

}
