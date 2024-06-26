<?php

namespace App\Modules\Currencies\Source;

use App\Modules\Currencies\Source\Enums\SourceEnum;
use App\Modules\Currencies\Source\Interface\Source;
use Illuminate\Support\Collection;

class ManualSource implements Source
{
    public function getPrices(): Collection
    {
        return new Collection([]);
    }

    public function enum(): SourceEnum
    {
        return SourceEnum::manual;
    }
}
