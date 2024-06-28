<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use function App\Helpers\uuid;

trait HasUuid
{
    public static function bootHasUuid() : void
    {

        //forceFill - если поле в модели не прописано, в $fillable - то оно все равно заполнится
        static::creating(function (Model $model){

            //минуем защиту от fillable
            $model->forceFill([
                'uuid' => uuid(),
            ]);

        });

    }
}
