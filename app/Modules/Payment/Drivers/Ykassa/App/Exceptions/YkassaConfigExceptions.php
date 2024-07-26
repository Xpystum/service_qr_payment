<?php
namespace App\Modules\Payment\Drivers\Ykassa\App\Exceptions;


use Exception;

class YkassaConfigExceptions extends Exception
{
    public function __construct($message = "Произошла ошибка", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
