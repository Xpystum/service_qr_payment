<?php

namespace App\Services\Auth\App\Action\Base;

use App\Services\Auth\App\Exception\AuthException;
use App\Services\Auth\Interface\AuthInterface;

abstract class AbstractAuthAction
{
    protected AuthInterface|null $authMethod = null;

    public function __construct(AuthInterface $authMethod)
    {
        $this->authMethod = $authMethod;
    }

    public static function make(AuthInterface $authMethod): static
    {
        return new static($authMethod);
    }

    public function error(\Throwable $error)
    {
        logger('Критическая Ошибка:', ['error' => $error]);
        throw new AuthException("Критическая Ошибка: {$error->getMessage()}");
    }


}
