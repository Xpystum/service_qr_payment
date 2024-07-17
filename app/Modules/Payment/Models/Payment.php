<?php
namespace App\Modules\Payment\Models;

use App\Helpers\Values\AmountValue;
use App\Modules\Payment\Enums\PaymentDriverEnum;
use App\Modules\Payment\Enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Payment extends Model
{

    use HasFactory;

    protected $fillable = [

        'uuid',

        'status',

        'currency_id', 'amount',

        'payable_type', 'payable_id',

        'method_id',

        'driver' ,

        'driver_currency_id',

        'amount',

        // 'driver_amount'

    ];

    protected $casts = [

        'status' => PaymentStatusEnum::class,

        'amount' => AmountValue::class,

        'driver' => PaymentDriverEnum::class,

    ];

    public function payable() : MorphTo
    {
        return $this->morphTo();
    }

    public function method() : BelongsTo
    {

        return $this->BelongsTo(PaymentMethod::class);
    }


}
