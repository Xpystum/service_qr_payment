<?php

namespace App\Modules\Payment\Enums\DriverInfo;

#TODO Возможно не понадобится удалить*
enum DriverInfoStorageEnum: string
{
    case test = '1001';

    case ykassa = '1002';

    /**
     * Здесь указываем все имеющиеся параметры
     * @return array
     */
    public function getParameters(): array
    {
        return match ($this) {

            self::ykassa => [
                DriverInfoParametrEnum::shopid,
                DriverInfoParametrEnum::key,
            ],

            self::test => [
                DriverInfoParametrEnum::key,
            ],

        };
    }

    public function getNameDriver(): string
    {
        return match ($this) {

            self::ykassa => 'ykassa',

            self::test => 'test',

        };
    }

    public function getParameterValue(string $key): ?string
    {
        $parameters = $this->getParameters();
        return $parameters[$key] ?? null;
    }

}
