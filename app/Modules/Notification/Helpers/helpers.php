<?php

namespace App\Modules\Notification\Helpers;
use Illuminate\Support\Str;

function uuid(string $path = '') : string
{
    return (string) Str::uuid();
}

function code() : string
{
    return (string) rand(100_000, 999_999);
}
