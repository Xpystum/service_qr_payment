<?php

namespace App\Modules\User\Policies;

use App\Modules\User\Models\User;
use App\Modules\User\Repositories\UserRepository;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;



//Terminal
    /**
     * Проверяем относится ли роль User к Admin или Manager который имеет доступ к терминалу
     * @param User $user
     *
     */
    public function terminal(User $user)
    {
        //проверяем роль у user
        $status = app(UserRepository::class)->userIsAmindOrManager($user);
        return $status ? $this->allow('User создал Terminal') : $this->deny('У этого user нету полномочий.');
    }


}
