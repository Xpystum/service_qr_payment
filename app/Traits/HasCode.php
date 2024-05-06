<?php

namespace App\Traits;

use App\Modules\Notifications\Models\Email;
use function App\Helpers\code;

trait HasCode
{
    public static function booted(): void
    {
        self::creating( function(Email $model) {

            $model->code = code();

        });
    }
}
