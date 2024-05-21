<?php

namespace App\Modules\Notification\Repositories;

use App\Modules\Notification\Enums\MethodNotificationEnum;
use App\Modules\Notification\Enums\NotificationDriverEnum;
use App\Modules\Notification\Models\NotificationMethod as Model;
use App\Modules\Notification\Repositories\Base\CoreRepository;
use Illuminate\Database\Eloquent\Collection;


class NotificationMethodRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    private function query() : \Illuminate\Database\Eloquent\Builder
    {
        return $this->startConditions()->query();
    }

    public function getMethodsAll() : Collection
    {
        return $this->query()->get();
    }

    public function getMethodId(int $id) : ?Model
    {
        return $this->query()->find($id);
    }

    public function getMethodName(string $name) : ?Model
    {
        return $this->query()->where('name', '=' , $name)->first();
    }

    public function getMethodByEnum(MethodNotificationEnum $method) : ?Model
    {
        return $this->query()->where('name', '=' , $method)->first();
    }

    public function getMethodByEnumDriver(NotificationDriverEnum $methodDriver) : ?Model
    {
        return $this->query()->where('driver', '=' , $methodDriver)->first();
    }

    public function getMethodNameAndDriver(NotificationDriverEnum $methodDriver, MethodNotificationEnum $methodName) : ?Model
    {
        return $this->query()
            ->where('driver', '=' , $methodDriver)
            ->where('name' , '=' , $methodName)
            ->first();
    }
}
