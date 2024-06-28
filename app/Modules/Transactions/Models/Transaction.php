<?php

namespace App\Modules\Transactions\Models;

use App\Helpers\Values\AmountValue;
use App\Modules\Terminal\Models\Terminal;
use App\Modules\Transactions\Enums\TransactionStatusEnum;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
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

        'amount' => AmountValue::class ,
    ];

    public function user(): BelongsTo
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


}
