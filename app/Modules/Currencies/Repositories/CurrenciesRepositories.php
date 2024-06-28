<?php
namespace App\Modules\Currencies\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\Currencies\Models\Currency as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class CurrenciesRepositories extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    public static function getRub() : ? Model
    {
        return self::getAllCached()->find('RUB');

    }

    private static function getAllCached() : Collection
    {
        // Таймаут кеширования в минутах (пример - 60 минут)
         $cacheTime = 60;

         // Ключ для кеша
         $cacheKey = 'all_currencies';

         // Проверяется наличие данных в кеше и возвращает их, если они существуют
         return Cache::remember($cacheKey, $cacheTime, function () {
            return Model::all(); // Запрос к базе данных, если данных в кеше нет
         });
    }
}
