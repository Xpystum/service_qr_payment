<?php

namespace App\Modules\Currencies\Source\Interface;

use App\Modules\Currencies\Source\Enums\SourceEnum;
use Illuminate\Support\Collection;

interface Source
{
    public function getPrices(): Collection;
    public function enum(): SourceEnum;

}
