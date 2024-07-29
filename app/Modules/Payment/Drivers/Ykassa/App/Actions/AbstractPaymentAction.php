<?php
namespace App\Modules\Payment\Drivers\Ykassa\App\Actions;

use App\Modules\Payment\Drivers\Ykassa\App\Exceptions\YkassaExceptions;
use App\Modules\Payment\Drivers\Ykassa\YkassaService;
use YooKassa\Client;

abstract class AbstractPaymentAction
{

    protected Client|null $clientSDK = null;
    protected YkassaService|null $ykassa = null;


    // protected =) ?
    public function __construct(YkassaService $ykassa) {

        $this->ykassa = $ykassa;
        $this->clientSDK = $ykassa->getClientSdk();
    }

    public static function make(YkassaService $ykassa): static
    {
        //при таком подходе, вызовится конструктор объекта через которого мы обращаемся.
        return new static($ykassa);
    }

    public function error(\Throwable $error)
    {
        logger('Критическая Ошибка:', ['error' => $error]);
        throw new YkassaExceptions("Критическая Ошибка: {$error->getMessage()}");
    }


}
