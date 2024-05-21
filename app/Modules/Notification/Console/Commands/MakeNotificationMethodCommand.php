<?php

namespace App\Modules\Notification\Console\Commands;


use App\Modules\Notification\Enums\MethodNotificationEnum;
use App\Modules\Notification\Enums\NotificationDriverEnum;
use App\Modules\Notification\Models\NotificationMethod;
use Illuminate\Console\Command;

class MakeNotificationMethodCommand extends Command
{

    protected $signature = 'notification-method:install';

    protected $description = 'Команда для создание методов нотификации в таблице';


    public function handle()
    {
        $this->warn('Создание методов нотификации...');

        $this->createNotificationModel();

        $this->info('Нотификации созданы успешны.');
    }

    public function createNotificationModel(): void
    {

        NotificationMethod::query()
            ->firstOrCreate(
                [
                    'name' => MethodNotificationEnum::email->value,
                ],

                [
                    'name' => MethodNotificationEnum::email->value,
                    'driver' => NotificationDriverEnum::smtp->value,
                    'active' => 'true',
                ]
        );

        NotificationMethod::query()
            ->firstOrCreate(
                [
                    'name' => MethodNotificationEnum::phone->value,
                ],

                [
                    'name' => MethodNotificationEnum::phone->value,
                    'driver' => NotificationDriverEnum::aero->value,
                    'active' => 'true'
                ],
        );

    }

}
