<?php

namespace App\Modules\Terminal\Models;

use App\Modules\Notification\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'user_id',
    ];

    protected $guarded = [
        'id', 'uuid'
    ];

    protected $cast = [
        
    ];

}
