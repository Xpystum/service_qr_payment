<?php

namespace App\Patterns\Handlers;

use App\Patterns\Handlers\Interface\HandlerInterface;

use function App\Helpers\Mylog;

abstract class AbstractHandler implements HandlerInterface
{
    private ?HandlerInterface $nextHandler = null;

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


        try {

            if (!is_null($data) && $this?->nextHandler) {
                return $this->nextHandler?->handle($data);
            }

        } catch (\Throwable $th) {
            Mylog('Ошибка при hanlde в AbstractHandler - пытается обратиться к {$this->nextHandler} до инициализации.' . $th);
        }


        return $data;
    }
    public static abstract function make() : self;

    protected abstract function process($data);
}
