<?php

namespace App\Modules\User\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\User\Enums\RoleUserEnum;
use App\Modules\User\Models\User as Model;
use App\Modules\User\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

use function App\Helpers\convertNullToEmptyString;

class UserRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * Проверить code у определённого user
     * @param int $code
     * @param int $userId
     *
     * @return bool
     */
    public function isNotificationConfirmed(Model $user = null, AuthService $authService) : bool
    {
        if($user === null) { $user = $authService->getUserAuth(); }

        $status = $user->email_confirmed_at || $user->phone_confirmed_at || null;

        return ($status === null) ? false : true;

    }

    public function lastNotify(Model $user = null, string $property)
    {
        return $user->lastNotify()->where('value' , $user->{$property})->first();
    }

    public function getUserByToken(AuthService $authService) {

        return $authService->getUserAuth();

    }

    public function getUser(?string $phone = null , ?string $email = null) : ?Model
    {

        if(!$phone && !$email) { return null; }

        $phone = convertNullToEmptyString($phone);
        $email = convertNullToEmptyString($email);

        $user = $this->query()
                    ->where('email', '=' , $email)
                    ->orWhere('phone' , '=' , $phone)
                    ->first();

        return $user;
    }

    /**
     * Вернуть пользователя по phone/email и если он прошёл регистрацию до конца
     *
     * @param string|null $phone
     * @param string|null $email
     *
     * @return Model|null
     */
    public function getUserAndRegister(?string $phone = null , ?string $email = null) : ?Model
    {

        if(!$phone && !$email) { return null; }

        $phone = convertNullToEmptyString($phone);
        $email = convertNullToEmptyString($email);

        $user = $this->query()
                    ->where('auth' , '=' , true)
                    ->where('email', '=' , $email)
                    ->orWhere('phone' , '=' , $phone)
                    ->first();

        return $user;
    }

    /**
     * Вернуть всех user которые принадлежат user:admin
     * @param User $user
     *
     * @return Collection|null
     */
    public function getAssocialUser(User $user) : \Illuminate\Support\Collection
    {
        $users = $this->query()
            ->join('personal_areas', 'users.personal_area_id', '=', 'personal_areas.id')
            ->where('personal_areas.owner_id', '=', $user->id)
            ->select('users.*')
            ->get();

        return $users;
    }

    /**
     * Проверить относится ли user к admin или manager
     * @param User $user
     *
     * @return bool
     */
    public function userIsAmindOrManager(User $user) : bool
    {
        $status = in_array($user->role, [RoleUserEnum::admin, RoleUserEnum::manager]);

        return $status;
    }

    /**
     * Проверяет на админа и на подтвреждение почты
     * @param User $user
     *
     * @return [type]
     */
    public function isAdmim(User $user) {

        $status = in_array($user->role, [RoleUserEnum::admin]);

        $status = $status && $user->auth;

        return  $status;
    }




}
