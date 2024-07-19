<?php
namespace App\Modules\Payment\Commands;

use App\Modules\Payment\Enums\DriverInfo\DriverInfoParametrEnum;
use App\Modules\Payment\Enums\DriverInfo\DriverInfoStorageEnum;
use App\Modules\Payment\Enums\PaymentDriverEnum;
use App\Modules\Payment\Models\DriverInfoStorage;
use Illuminate\Console\Command;

class AddYkassaComand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:ykassa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Команда для добавление конфигурационных параметров юкассы в базу данных DriverInfoStorages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->warn('Установка конфигурационных данных юкассы...');

        $this->start();

        $this->info('Конфигурационные данные установлены.');
    }

    public function start()
    {

        // Получаем список enum методов платежей с их параметрами

        DriverInfoStorage::firstOrCreate([
            'type_id' => 1002,
            'type_name' => PaymentDriverEnum::ykassa,
            'parametr_name' => DriverInfoParametrEnum::shopid,
        ]);

        DriverInfoStorage::firstOrCreate([
            'type_id' => 1002,
            'type_name' => PaymentDriverEnum::ykassa,
            'parametr_name' => DriverInfoParametrEnum::key,
        ]);

        DriverInfoStorage::firstOrCreate([
            'type_id' => 1001,
            'type_name' => PaymentDriverEnum::test,
            'parametr_name' => DriverInfoParametrEnum::apikey,
        ]);

    }
}
