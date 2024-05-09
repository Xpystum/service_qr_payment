<?php

namespace App\Modules\Notifications\Traits;

use App\Modules\Notifications\Models\Email;
use Illuminate\Database\Eloquent\Model;

use function App\Helpers\code;

trait UpdateCode
{
    public static function booted(): void
    {
        self::updating(function (Model $model) {

            $model->code = code();

        });
    }
}
