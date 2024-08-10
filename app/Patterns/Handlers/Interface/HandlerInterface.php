<?php

namespace App\Patterns\Handlers\Interface;

interface HandlerInterface
{
    public function setNext($handler);

    public function handle($request);

}
