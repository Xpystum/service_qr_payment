<?php

namespace App\Modules\Terminal\Action\Terminal;

use App\Modules\Terminal\Models\Terminal;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateTerminalAction
{
    public static function run(User $user, string $name) : Terminal
    {

            $terminal = Terminal::create([
                'user_id' => $user->id,
                'name' => $name,
            ]);


        if(!$terminal->save()){
            throw new ModelNotFoundException('Не удалось создать терминал.', 500);
        }

        return $terminal;
    }
}
