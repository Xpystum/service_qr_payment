<?php
namespace App\Modules\Payment\Drivers\Ykassa;

use App\Modules\Payment\Drivers\Ykassa\App\Exceptions\YkassaConfigExceptions;
use App\Modules\Payment\Enums\DriverInfo\DriverInfoParametrEnum;
use App\Modules\Payment\Enums\PaymentDriverEnum;
use App\Modules\Payment\Repositories\DriverInfoRepository;
use App\Modules\User\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

use function App\Helpers\Mylog;

class YkassaConfig
{
    private ?string $key = null;
    private ?string $shopId = null;
    private ?User $user;
    public function __construct(

        private AuthService $authService, //получаем сервес auth что бы получить user (либо нам придётся его большой цепочкой перекидывать)

    ) {

        $this->user = $authService->getUserAuth();

        if($this->user)
        {
            //делаем уникальный ключ кеша для каждого user
            $key = 'parametrPaymentYkassa_' . $this->user->id;

            //используем кеш, в последующих запросов
            $this->cache($key);
        }

    }

    public function getKey() : ?string
    {
        return $this->key;
    }

    public function getShopId() : ?string
    {
        if(is_null($this->shopId)) { return null; }

        if(is_numeric($this->shopId))
        {
            return $this->shopId;
        } else {

            Mylog('Ошибка в YkassaConfig, связанная с ShopId - не может перобрезоваться из строки в число.');
            throw new YkassaConfigExceptions('Не правильный параметр, ShopId должен состоять из цифр.', 500);
        }
    }

    private function cache(string $key)
    {
        try {

            if(!Cache::has($key))
            {
                Cache::remember($key, 3600, function () {
                    return $this->getArrayParametr();
                });

            }

            if (Cache::has($key) && !Cache::get($key)->isEmpty()) {

                $array = Cache::get($key);

                $this->shopId = $array['shopId'];
                $this->key = $array['key'];
            }


        } catch (\Throwable $th) {

            Mylog('Ошибка в YkassaConfig, связанная с кешем.');
            throw new YkassaConfigExceptions('Ошибка в записи в кеш и получения данных из кеша.', 500);

        }



    }

    private function getArrayParametr() : Collection
    {
        //получаемм значения из бд устанавливаем свойствам класса значения параметров платежной системы
        $this->setParamByDbCollection();

        //собираем массив из значений у нашего config
        $array = [
            'key' => $this->key ?? throw new YkassaConfigExceptions('Ошибка параметров платежной системы, у пользователя не задан {Key} - Ykassa', 500),
            'shopId' => $this->shopId ?? throw new YkassaConfigExceptions('Ошибка параметров платежной системы, у пользователя не задан {Shop id} - Ykassa', 500),
        ];

        return collect($array);
    }

    private function setParamByDbCollection()
    {

        $driverInfoRepository = app(DriverInfoRepository::class);
        $modelArray = $driverInfoRepository->getAllDriverInfoByType(PaymentDriverEnum::ykassa, $this->user->id);


        foreach ($modelArray as $model) {

            switch ($model->parametr) {
                case DriverInfoParametrEnum::shopid:
                {
                    $this->shopId = $model?->value;
                    break;
                }

                case DriverInfoParametrEnum::key:
                {
                    $this->key = $model?->value;
                    break;
                }

                default: { break; }
            }

        }

    }



}
