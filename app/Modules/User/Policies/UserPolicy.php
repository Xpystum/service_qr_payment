<?php

namespace App\Modules\User\Policies;

use App\Modules\User\Models\User;
use App\Modules\User\Repositories\UserRepository;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Проверяем относится ли роль User к Admin или Manager
     * @param User $user
     *
     */
    public function createTerminal(User $user)
    {
        //проверяем роль у user и во
        $status = app(UserRepository::class)->userIsAmindOrManager($user);
        return $status ? $this->allow('User создал Terminal') : $this->deny('У этого user нету полномочий.');
    }
}
