<?php

namespace App\Modules\User\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\User\Models\User as Model;
use App\Services\Auth\AuthService;
use App\Traits\TraitAuthService;

use function App\Helpers\convertNullToEmptyString;

class UserRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    private function query() : \Illuminate\Database\Eloquent\Builder
    {
        return $this->startConditions()->query();
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
}
