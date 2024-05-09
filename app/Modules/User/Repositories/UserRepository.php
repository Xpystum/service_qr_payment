<?php

namespace App\Modules\User\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\Notifications\Models\Email as Model;
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
    public function isEmailConfirmed() : bool
    {
        $user = $this->authService->getUserAuth();

        $status = $user->email_confirmed_at;

        return ($status === null) ? false : true;

    }
}
