<?php

namespace App\Modules\Notification\Traits;

use Illuminate\Database\Eloquent\Model;

use function App\Modules\Notification\Helpers\code;

trait HasCode
{
    public static function booted(): void
    {
        self::creating( function(Model $model) {

            $model->code = code();

        });
    }
}
