<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

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

