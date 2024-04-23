<?php

namespace App\Services\Auth\DTO;
use Illuminate\Contracts\Support\Arrayable;

abstract class BaseDTO implements Arrayable
{
    public abstract function toArray() : array;
}
