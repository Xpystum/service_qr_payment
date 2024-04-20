<?php


namespace App\Console\Commands;
use App\Modules\User\Models\User;
use Illuminate\Console\Command;

class CreateUserCommand extends Command
{
    protected $signature = 'users:create';

    protected $description = 'Создание User';

    public function handle()
    {
        $user = new User();

        $user->phone = $this->ask("Установите phone User", '');

        $user->email = $this->ask("Установите email User", 'test@gmail.com');

        $user->password = $this->ask("Установите email User", 'Pas123!');

        $user->save();

        $this->info('Пользователь создан');

    }
}
