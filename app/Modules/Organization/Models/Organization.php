<?php

namespace App\Modules\Organization\Models;

use App\Modules\Organization\Enums\TypeOrganizationEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        
    ];

    protected $guarded = [

    ];


    protected $hidden = [

    ];


    protected $casts = [
        'type' => TypeOrganizationEnum::class
    ];
}
