<?php

namespace App\Modules\Notifications\Action;

use App\Modules\Notifications\DTO\CreatEmailDto;
use App\Modules\Notifications\Models\Email;
use Exception;

class CreateEmailAction
{
    public static function run(CreatEmailDto $data) : ?Email
    {

        try {

            $email = Email::query()->create([

                'value' => $data->value,
                'user_id' => $data->user_id,
                'status' => $data->status,

            ]);

            return $email;

        } catch (Exception $exception) {

            return false;

        }

    }

}
