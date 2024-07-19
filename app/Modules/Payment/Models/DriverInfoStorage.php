<?php

namespace App\Modules\Payment\Models;

use App\Modules\Payment\Enums\DriverInfo\DriverInfoParametrEnum;
use App\Modules\Payment\Enums\PaymentDriverEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DriverInfoStorage extends Model
{
    use HasFactory;

    protected $table = 'driver_info_storages';
    public $timestamps = false;

    protected $fillable = [
        'type_name',
        'type_id',
        'parametr_name'
    ];

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'type_name' => PaymentDriverEnum::class,
        'parametr_name' => DriverInfoParametrEnum::class,
    ];

    public function storage(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'type_id');
    }
}
