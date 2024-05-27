<?php

namespace App\Modules\Notification\DTO\Config;

/**
 * DTO конфигна для драйвера Aero
 * @param
 */
class AeroConfigDTO
{
    public function __construct(
        public string $email,
        public string $apiKey,
        public string $sign = 'SMS Aero',
    ) { }


    /**
     * Возвращает true если "все" данные заполнены
     * @return bool
     */
    public function checkProperty() : bool
    {
        if($this->email && $this->apiKey)
        {
            return true;
        }

        return false;
    }
}
