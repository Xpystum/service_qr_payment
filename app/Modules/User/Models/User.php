<?php


namespace App\Modules\User\Models;

use App\Modules\Notifications\Models\Email;
use App\Modules\User\Enums\RoleUserEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [

        'id',
        'phone',
        'email',
        'active',
        'password',

        'first_name',
        'last_name',
        'father_name',

        'email_confirmed_at',
        'phone_confirmed_at',

        'role',


    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // 'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'active' => 'boolean',
        'password' => 'hashed',
        'role' => RoleUserEnum::class,
        'email_confirmed_at' => 'datetime',
        'phone_confirmed_at' => 'datetime',
    ];


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    // public function emails(): HasMany
    // {
    //     return $this->hasMany(Email::class);
    // }

}
