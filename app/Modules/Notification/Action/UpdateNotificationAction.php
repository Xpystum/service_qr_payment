<?php

namespace App\Modules\Notification\Action;

use App\Modules\Notification\Enums\ActiveStatusEnum;
use App\Modules\Notification\Models\Notification;


use function App\Modules\Notification\Helpers\code;

class UpdateNotificationAction
{

    private ?string $code = null;

    public function updateCode()
    {

        $this->code = code();

        return $this;
    }

    public function run(Notification $model)
    {
        if($this->code && $model->status != ActiveStatusEnum::completed)
        {
            $model->code = code();
            return $model->save();
        }

        return false;
    }

}
