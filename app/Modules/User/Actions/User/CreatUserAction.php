<?php

namespace App\Modules\User\Actions\User;

use App\Modules\User\DTO\CreatUserDTO;

use App\Modules\User\Models\User;
use App\Patterns\Handlers\AbstractHandler;
use Illuminate\Support\Facades\DB;

class CreatUserAction extends AbstractHandler
{
    private ?User $user = null;
    /**
     *
     * @param CreatUserDTO $data
     * @return User
     */
    protected function process($data)
    {
        return $this->user = $this->run($data);
    }

    public static function make() : self
    {
        return new self();
    }

    public function getUser() : User
    {
        return $this->user;
    }

    public function setUser(User $user) : void
    {
       $this->user = $user;
    }

    public static function run(CreatUserDTO $data) : User
    {
        $user = DB::transaction(function () use ($data) {

            return User::firstOrCreate(
                ['email' => $data->user->email, 'phone' => $data->user->phone ], // Критерии для поиска пользователя
                ['password' =>  $data->user->password, 'personal_area_id' => $data->personal_area_id, ] // Данные нового пользователя
            );

        });

        //p.s если мы это не сделаем, мы не будем получать поля которые ставятся default в бд при создании модели
        $user->refresh();

        return $user;
    }

}
