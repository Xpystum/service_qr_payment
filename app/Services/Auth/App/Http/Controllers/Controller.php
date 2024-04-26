<?php

namespace App\Services\Auth\App\Http\Controllers;

use App\Services\Auth\App\Exceptions\Error\ExceptionAccessIsDenied;
use App\Services\Auth\App\Exceptions\Error\ExceptionInvalidRequest;
use App\Services\Auth\App\Exceptions\Error\ExceptionNotFound;
use App\Services\Auth\App\Exceptions\Error\ExceptionServerError;
use App\Services\Auth\App\Exceptions\Error\ExceptionUnauthorized;
use App\Services\Auth\App\Exceptions\Error\ExceptionUnprocessedObject;

abstract class Controller
{
    protected function exceptionNotFound(string $message, int $code = 404)
    {
        ($message === '') ? $message = 'Не найдено (страница или другой ресурс не существует)' : '';
        throw new ExceptionNotFound($message, $code);
    }

    protected function exceptionAccessIsDenied(string $message , int $code = 403)
    {
        ($message === '') ? $message = 'Вы вошли в систему, но доступ к запрашиваемой области запрещен.' : '';
        throw new ExceptionAccessIsDenied($message, $code);
    }

    protected function exceptionUnauthorized(string $message = '', int $code = 401)
    {
        ($message === '') ? $message = 'Не авторизован' : '';
        throw new ExceptionUnauthorized($message, $code);
    }


    protected function exceptionInvalidRequest(string $message, int $code = 400)
    {
        ($message === '') ? $message = 'Неверный запрос (что-то не так с URL-адресом или параметрами)' : '';
        throw new ExceptionInvalidRequest($message, $code);
    }

    protected function exceptionUnprocessedObject(string $message , int $code = 422)
    {
        ($message === '') ? $message = 'Необрабатываемый объект (проверка не удалась)' : '';
        throw new ExceptionUnprocessedObject($message, $code);
    }

    protected function exceptionServerError(string $message , int $code = 500)
    {
        ($message === '') ? $message = 'Общая ошибка сервера' : '';
        throw new ExceptionServerError($message, $code);
    }

    protected function abort_unless($boolean, int $code, string $message = ''): void
    {


        if(!(bool) $boolean){

            match($code){

                404 => $this->exceptionNotFound($message),
                403 => $this->exceptionAccessIsDenied($message),
                401 => $this->exceptionUnauthorized($message),
                400 => $this->exceptionInvalidRequest($message),
                422 => $this->exceptionUnprocessedObject($message),
                500 => $this->exceptionServerError($message),

            };

        }

    }

    private function isMessage($message){
        return ($message === '') ? $message = $message : '' ;
    }
}
