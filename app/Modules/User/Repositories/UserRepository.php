<?php

namespace App\Modules\User\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\User\Models\User as Model;
use App\Traits\TraitAuthService;

class UserRepository extends CoreRepository
{

    use TraitAuthService;

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
    public function isNotificationConfirmed(Model $user = null) : bool
    {
        if($user === null) { $user = $this->authService->getUserAuth(); }

        $status = $user->email_confirmed_at || $user->phone_confirmed_at || null;

        return ($status === null) ? false : true;

    }

    public function lastNotify(Model $user = null, string $property)
    {
        return $user->lastNotify()->where('value' , $user->{$property})->first();
    }


    public function getUserByToken() {

        return $this->authService->getUserAuth();

    }
}
