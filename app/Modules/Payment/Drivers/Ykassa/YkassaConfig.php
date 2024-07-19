<?php
namespace App\Modules\Payment\Drivers\Ykassa;


class YkassaConfig
{

    public function __construct(

        public string $key,

        public string $shopId,

    ) { }

}
