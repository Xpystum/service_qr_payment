<?php

namespace App\Modules\Notifications\Models;

use App\Modules\Notifications\Enums\ActiveStatusEnum;
use App\Traits\HasCode;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasUuid;
    use HasCode;
    use HasFactory;

    protected $fillable = [
        'uuid',
        'value',
        'user_id',
        'status',
        'code',
    ];

    protected $casts = [
        'status' => ActiveStatusEnum::class,
        'code' => 'encrypted',
    ];

    // public static function booted(): void
    // {
    //     self::creating(function (Email $email) {
    //         $email->code = code();
    //     });
    // }

    // public function complete(): bool
    // {
    //     return $this->updateStatus(EmailStatusEnum::completed);
    // }

    // public function updateStatus(EmailStatusEnum $status): bool
    // {
    //     if ($this->status->is($status)) {
    //         return false;
    //     }

    //     return $this->update(compact('status'));
    // }
}
