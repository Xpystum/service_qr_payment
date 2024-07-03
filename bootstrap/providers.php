<?php


return [
    App\Providers\AppServiceProvider::class,
    App\Providers\AuthServiceProvider::class,
    Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
    App\Modules\Notification\Services\NotificationServiceProvider::class,
    App\Modules\Payment\Service\PaymentServiceProvider::class,
];
