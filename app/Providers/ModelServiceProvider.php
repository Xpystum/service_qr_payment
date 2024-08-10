<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;

class ModelServiceProvider extends ServiceProvider
{


    public function boot(): void
    {
        //таким способом при тестировании проекта мы можем найти ошибки где выполняется запросы n+1
        Model::preventLazyLoading(
            !app()->environment('production') //проверяем находимся ли мы в продакшене
        );
    }
}
