<?php

namespace App\Modules\Currencies\Commands;

use App\Helpers\Values\AmountValue;
use App\Modules\Currencies\Models\Currency;
use App\Modules\Currencies\Source\Enums\SourceEnum;
use Illuminate\Console\Command;

class InstallCurrenciesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currencies:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Сервис для работы с валютами';

    public function handle()
    {
        $this->warn('Установка валют...');

        $this->installCurrencies();

        $this->info('Валюты установлены.');
    }

    private function installCurrencies(): void
    {

        Currency::query()
            ->firstOrCreate(
                ['id' => Currency::RUB],
                [
                    'name' => 'Рубль',
                    'price' => new AmountValue(1),
                    'source' => SourceEnum::manual //источник цены - например из мануала или центрального банка россии
                ],
        );

        // Currency::query()
        //     ->firstOrCreate(
        //         ['id' => Currency::USD]
        //         ,
        //         [
        //             'name' => 'Доллар',
        //             'price' => new AmountValue(100),
        //             'source' => SourceEnum::cbrf
        //         ],
        // );

        // Currency::query()
        //     ->firstOrCreate(
        //         ['id' => Currency::EUR]
        //         ,
        //         [
        //             'name' => 'Евро',
        //             'price' => new AmountValue(110),
        //             'source' => SourceEnum::cbrf
        //         ],
        // );
    }
}
