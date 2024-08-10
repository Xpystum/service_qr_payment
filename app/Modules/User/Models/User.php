<?php


namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Modules\Base\Enums\ActiveStatusEnum;
use App\Modules\Notification\Models\Notification;
use App\Modules\Notification\Traits\HasUuid;
use App\Modules\Payment\Models\DriverInfo;
use App\Modules\Terminal\Models\Terminal;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Modules\User\Enums\RoleUserEnum;
use App\Modules\User\Observers\UserObserver;

    //Factory
use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\UserFactory;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[ObservedBy([UserObserver::class])] // наблюдатель p.s не акутально можно убрать (оставил для примера)
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasUuid;

    protected $fillable = [

        'phone',
        'email',
        'password',

        'first_name',
        'last_name',
        'father_name',

        'email_confirmed_at',
        'phone_confirmed_at',

        'personal_area_id',

    ];

    protected $guarded = [
        'uuid',
        'role',
        'active',
        'auth',
        'id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'auth' => 'boolean',
        'active' => 'boolean',
        'password' => 'hashed',
        'role' => RoleUserEnum::class,
        'email_confirmed_at' => 'datetime',
        'phone_confirmed_at' => 'datetime',
    ];

    /**
    * привязка модели к фактори
    */
    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }


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

    public function driverinfo(): HasMany
    {
        return $this->hasMany(DriverInfo::class);
    }

    public function terminal(): HasMany
    {
        return $this->hasMany(Terminal::class);
    }

    public function notifycation(): HasMany
    {
        return $this->hasMany(Notification::class);
    }


    public function lastNotify() : HasMany
    {
        return $this->hasMany(Notification::class);
    }

    //возвращает последнию нотификацию (по значению нотификации и статусу)
    public function lastNotifyAndPending()
    {
        return $this->lastNotify()
            ->where('value', $this->value)
            ->where('status', ActiveStatusEnum::pending);
    }

    public function lastNotifyAndCompleted()
    {
        return $this->lastNotify()
            ->where('value', $this->value)
            ->where('status', ActiveStatusEnum::completed);
    }


    /**
     * Вернуть кабинет к которому принадлежит user
     * @return BelongsTo
     */
    public function personalArea() : BelongsTo
    {
        return $this->belongsTo(PersonalArea::class, 'personal_area_id');
    }

    /**
     * Вернуть кабинет администратора. (при условии что пользователь админ)
     * @return HasOne
     */
    public function adminArea() : HasOne
    {
        //при состоянии когда user админ, мы можем указать что связь у нас будет 1к1 т.е Админ может иметь 1 кабинет.
        return $this->hasOne(PersonalArea::class, 'owner_id')->where('owner_id', $this->id);
        // if($this->role->isAdmin()) { return $this->hasOne(PersonalArea::class, 'owner_id'); }
        // else { return null; }
    }

}
