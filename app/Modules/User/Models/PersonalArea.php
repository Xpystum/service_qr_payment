<?php

namespace App\Modules\User\Models;

use App\Modules\Notification\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalArea extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'personal_areas';

    protected $fillable = [
        'owner_id',
    ];

    protected $guarded = [
        'uuid',
        'id',
        'created_at',
        'updated_at',
    ];


    protected $casts = [

    ];
}
