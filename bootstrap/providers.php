<?php

return [
    App\Modules\Notification\Services\NotificationServiceProvider::class,
    App\Modules\Payment\Service\PaymentServiceProvider::class,
    App\Providers\AppServiceProvider::class,
    App\Providers\AuthServiceProvider::class,
    App\Providers\ModelServiceProvider::class,
    Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
];
