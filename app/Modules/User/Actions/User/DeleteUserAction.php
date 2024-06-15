<?php

namespace App\Modules\User\Actions\User;

use App\Modules\User\Models\User;
use App\Modules\User\Repositories\UserRepository;

use function App\Helpers\Mylog;

class DeleteUserAction
{
    public function __construct(public UserRepository $userRepository) {}

    public static function run(string $uuid = null) : bool
    {

        //получаем user у которого есть personArea - если у него нет (он не может быть удалён)
        $user = User::query()
                    ->where('uuid', '=' , $uuid)
                    ->whereNotNull('personal_area_id')
                    ->first();

        if(!$user) {
            return false;
        }

        try {
            $status = $user->deleteOrFail();
        } catch (\Throwable $th) {
            Mylog('Ошибка удаление user по uuid которого не существуют');
            throw new \Exception('Такого user по uuid - не существует', 404);
        }

        return $status;
    }

}
