<?php

namespace App\Modules\Transactions\Models;

use App\Helpers\Values\AmountValue;
use App\Modules\Payment\Interface\Payable;
use App\Modules\Payment\Models\Payment;
use App\Modules\Terminal\Models\Terminal;
use App\Modules\Transactions\Enums\TransactionStatusEnum;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Transaction extends Model implements Payable
{
    use HasFactory, HasUuid;

    protected $fillable = [

        'status',
        'terminal_id',
        'driver_currency_id',
        'amount'

    ];

    protected $guarded = [
        'id', 'uuid'
    ];

    protected $cast = [

        'status' => TransactionStatusEnum::class,

        'amount' => AmountValue::class,

    ];

    public function terminal(): BelongsTo
    {
        return $this->belongsTo(Terminal::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if(empty($model->status))
            {
                $model->status = TransactionStatusEnum::pending;
            }

        });
    }

    public function Payment(): MorphOne
    {
        return $this->morphOne(Payment::class, 'payabel');
    }

    public function getPayableCurrencyId(): string
    {
        return $this->driver_currency_id;
    }

    public function getPayableAmount(): AmountValue
    {
        return new AmountValue($this->amount);
    }

    public function getPayableType(): string
    {
        return $this->getMorphClass();
    }

    public function getPayableId(): int
    {
        return $this->id;
    }

    public function getPayableName(): string
    {
        return 'Транзакция';
    }

}
