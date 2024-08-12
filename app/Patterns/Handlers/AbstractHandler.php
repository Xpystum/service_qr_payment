<?php

namespace App\Patterns\Handlers;

use App\Patterns\DataTransferObject\BaseDTO;
use App\Patterns\Handlers\Interface\HandlerInterface;

abstract class AbstractHandler implements HandlerInterface
{
    private ?HandlerInterface $nextHandler;

    public function setNext($handler)
    {
        if($handler) {
            $this->nextHandler = $handler;
            return $handler;
        }

        return null;

    }

    public function handle($request)
    {
        //получаем значение из запроса и прокидываем его дальше
        $data = $this->process($request);

        if (!is_null($data) && $this->nextHandler) {
            return $this->nextHandler?->handle($data);
        }


        return $data;
    }
    public static abstract function make() : self;

    protected abstract function process($data);
}
