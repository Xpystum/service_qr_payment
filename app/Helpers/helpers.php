<?php

namespace App\Helpers;

use App\Modules\User\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

//Response helpers
function array_success($data = null , string $message = 'success') : array
{
    //mb_convert_encoding для кодировки строки из (полученной mb_detect_encoding() в utf-8)
    return [
        'data' => $data,
        'message' => mb_convert_encoding($message, 'utf-8', mb_detect_encoding($message)),
    ];

}

function array_error($data = null , string $message = 'error') : array
{
    //mb_convert_encoding для кодировки строки из (полученной mb_detect_encoding() в utf-8)
    return [
        'data' => $data,
        'message' => mb_convert_encoding($message, 'utf-8', mb_detect_encoding($message)),
    ];

}



function uuid(string $path = '') : string
{
    return (string) Str::uuid();
}

function code() : string
{
    return (string) rand(100_000, 999_999);
}

function Mylog(string $message) : void
{
    $backtrace = debug_backtrace();
    // Извлекаем информацию о вызове для уровня выше функции myFunction, то есть самого вызывающего.
    $caller = $backtrace[1];

    Log::info($message . ' ' . now() . " ------> " . 'Debug backtrace: ' . 'Function called from file: ' . $caller['file'] . ' on line ' . $caller['line']);
}


function valueIfSet(&$var, $default = null) {

    return isset($var) ? $var : $default;

}

function convertNullToEmptyString($var)
{
    if($var === null)
    {
        return '';
    }

    return $var;
}

function isAuthorized(AuthService $authService) : User
{
    /**
    * получаем авторизированного user
    * @var User
    */

    $user = $authService->getUserAuth();

    abort_unless( (bool) $user, 401, "Не авторизован");

    return $user;
}



