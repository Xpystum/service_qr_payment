<?php

namespace App\Modules\Notification\Action;

use App\Modules\Notification\Enums\MethodNotificationEnum;
use App\Modules\Notification\Enums\NotificationDriverEnum;
use App\Modules\Notification\Traits\ConstructNotifyMethodRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

use function App\Helpers\Mylog;

class GetMethodAction
{
    use ConstructNotifyMethodRepository;

    private ?MethodNotificationEnum $enumMethodName = null;

    private ?NotificationDriverEnum $enumMethodDriver = null;

    private bool $flag = false;

    public function activeCache() : static
    {
        $this->flag = true;

        return $this;
    }

    public function methodName(MethodNotificationEnum $enumMethodName) : static
    {
        $this->enumMethodName = $enumMethodName;
        return $this;
    }

    public function methodDriver(NotificationDriverEnum $enumMethodName) : static
    {
        $this->enumMethodDriver = $enumMethodName;

        return $this;
    }

    public function first() : ?Model
    {

        if($this->flag){

            if($this->enumMethodName && $this->enumMethodDriver)
            {

                $valueCache = $this->useCache();
                return $valueCache
                        ->where('name', $this->enumMethodName)
                        ->where('driver', $this->enumMethodDriver)->first();

            }
            elseif($this->enumMethodName)
            {
                $valueCache = $this->useCache();
                return $valueCache->firstWhere('name', $this->enumMethodName);

            }
            elseif($this->enumMethodDriver) {

                $valueCache = $this->useCache();
                return $valueCache->firstWhere('driver', $this->enumMethodDriver);
            }
            else{

                throw new \InvalidArgumentException('Ошибка драйвера');
                return null;
            }

        } else {

            if($this->enumMethodName && $this->enumMethodDriver)
            {
                return $this->repository->getMethodNameAndDriver($this->enumMethodDriver, $this->enumMethodName);
            }
            elseif ($this->enumMethodName)
            {
                return $this->repository->getMethodByEnum($this->enumMethodName);
            }
            elseif ($this->enumMethodDriver)
            {
                return $this->repository->getMethodByEnumDriver($this->enumMethodDriver);
            }
            else {
                return null;
            }

        }

    }

    private function useCache()
    {
        $key = 'notificationMethod';

        if(!Cache::has($key))
        {
            Cache::remember($key, 3600, function ()  {
                return $this->repository->getMethodsAll();
            });
        }

        if (Cache::has($key) && !Cache::get($key)->isEmpty()) {
            return Cache::get($key);
        } else {

            Cache::forget($key);
            Cache::remember($key, 3600, function ()  {
                return $this->repository->getMethodsAll();
            });

            Mylog('Ошибка при котором у нас не записываются данные в кеш и возвращается null');
            throw new \Exception('Ошибка в записи в кеш и получения данных из кеша.', 500);

        }

    }

}
