<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallAplicationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:application';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Запуск команд для работы приложения';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->warn('Установка приложения...');

        {
            // Установка в бд методов оплаты
            $this->call('notification-method:install');

            // установка валют
            $this->call('currencies:install');

            //  установка платежных методов (Банки, платежные агрегаты и т.д)
            $this->call('payments:install');

            // установка конфигурационных данных юкассы (добавление в бд)
            $this->call('payments:install');
        }

        $this->info('Приложения успешно установлено!');
}
}
