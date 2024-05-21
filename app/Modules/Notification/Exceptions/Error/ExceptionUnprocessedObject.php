<?php
namespace App\Services\Auth\App\Exceptions\Error;

use App\Services\Auth\App\Exceptions\Error\Trait\ExceptionResponseTrait;
use Exception;

class ExceptionUnprocessedObject extends Exception
{
    use ExceptionResponseTrait;

}
