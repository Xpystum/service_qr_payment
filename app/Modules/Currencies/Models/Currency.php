<?php

namespace App\Modules\Currencies\Models;

use App\Helpers\Values\AmountValue;
use App\Modules\Currencies\Source\Enums\SourceEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Currency extends Model
{
    use HasFactory;

    public const MAIN = 'RUB';

    public const RUB = 'RUB';
    public const USD = 'USD';
    public const EUR = 'EUR';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id', 'name',

        'price', 'source'
    ];

    protected $casts = [

        'source' => SourceEnum::class,

        'price' => AmountValue::class

    ];

    public function isMain(): bool
    {
        return $this->id === static::MAIN;
    }

    public function isNotMain(): bool
    {
        return !$this->isMain();
    }

    /**
     * @return Collection
     */
    public static function getCached(): Collection
    {

        static $cached;

        if($cached)
        {
            return $cached;
        }

        return $cached = static::all();
    }
}
