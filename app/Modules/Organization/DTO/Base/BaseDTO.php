<?php

namespace App\Modules\Organization\DTO\Base;

abstract class BaseDTO
{
    public abstract function filterNull() : array;

}
