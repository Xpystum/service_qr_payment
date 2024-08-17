<?php

namespace App\Modules\Organization\Models;

use App\Modules\Notification\Traits\HasUuid;
use App\Modules\Organization\Enums\TypeOrganizationEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'name',
        'address',
        'owner_id',
        'phone_number',
        'email',
        'website',
        'type',
        'description',
        'industry',
        'founded_date',
        'inn',
        'kpp',
        'registration_number',
        'registration_number_individual',
    ];

    protected $guarded = [
        'ip',
        'uuid'
    ];


    protected $hidden = [

    ];


    protected $casts = [
        'type' => TypeOrganizationEnum::class
    ];

    public static function findByUuid(string $uuid) : ?Organization
    {
        return self::where('uuid', '=' , $uuid)->first();
    }
}
