<?php

namespace App\Patterns\Handlers;

use App\Patterns\DataTransferObject\BaseDTO;
use App\Patterns\Handlers\Interface\HandlerInterface;

abstract class AbstractHandler implements HandlerInterface
{
    private HandlerInterface $nextHandler;

    public function setNext($handler)
    {
        $this->nextHandler = $handler;
        return $handler;
    }

    public function handle($request)
    {
        $this->process($request);

        if ($this->nextHandler) {
            return $this->nextHandler->handle($request);
        }

        return;
    }

    /**
    * @param BaseDTO $request
    */
    protected abstract function process(BaseDTO $data);
}
