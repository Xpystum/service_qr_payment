<?php


namespace App\Modules\Currencies\Source\Factories;

use App\Modules\Currencies\Source\CbrfSource;
use App\Modules\Currencies\Source\Enums\SourceEnum;
use App\Modules\Currencies\Source\Interface\Source;
use App\Modules\Currencies\Source\ManualSource;

class SourceFactory
{

    public static function make(SourceEnum $source): Source
    {

        return match ($source){

            SourceEnum::manual => app(ManualSource::class),
            SourceEnum::cbrf => app(CbrfSource::class),

        };

    }
}
