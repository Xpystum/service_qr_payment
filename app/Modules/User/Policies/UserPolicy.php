<?php

namespace App\Modules\User\Policies;

use App\Modules\User\Models\User;
use App\Modules\User\Repositories\UserRepository;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Проверяем относится ли роль User к Admin или Manager который имеет доступ к терминалу
     * @param User $user
     *
     */
    public function admin_or_manager(User $user)
    {
        //проверяем роль у user
        $status = app(UserRepository::class)->userIsAmindOrManager($user);
        return $status ? $this->allow('Данному пользователю разрешено действие.') : $this->deny('У этого пользователя нету полномочий.');
    }

    /**
     * Проверяем админа на законченную регистрацию
     * @return [type]
     */
    public function admin_is_ready_register(User $user)
    {
        $status = app(UserRepository::class)->isAdmim($user);
        return $status ? $this->allow('Данному пользователю разрешено действие.') : $this->deny('У этого пользователя нету полномочий.');
    }

    /**
     * Проверяем относится ли роль User, только к админу
     * @param User $user
     *
     */
    public function only_admin(User $user)
    {
        //проверяем роль у user
        $status = app(UserRepository::class)->isAdmim($user);
        return $status ? $this->allow('Данному пользователю разрешено действие.') : $this->deny('У этого пользователя нету полномочий.');
    }


}
