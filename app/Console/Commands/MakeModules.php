<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Artisan;
use Psy\Readline\Hoa\Console;

class MakeModules extends Command
{


    public const FOLDERS = ['Action', 'Repositories', 'Models' , 'DTO', 'Requests', 'Resources'];

    protected $signature = 'make:module';

    protected $description = 'Создание структуры папок Модуля (Module)';

    public function handle()
    {

        $nameModule = $this->ask("Установите название Модуля:");

        $this->createModule($nameModule);

        $this->info('Модуль успешно создан.');
    }

    public function createModule(string $nameModule)
    {
        $path = ("app/Modules/" . $nameModule);

        $pathModel = ("Modules\\"  . $nameModule . "\Models\\" . $nameModule);

        File::makeDirectory($path, 0777, true);

        foreach(self::FOLDERS as $folder){

            if($folder == 'Models')
            {
                // Выполняет команду artisan make:model
                Artisan::call('make:model', [
                    'name' => $pathModel,
                    '--migration' => true,
                ]);

                continue;
            }

            File::makeDirectory($path . '/' . $folder);
        }
    }
}
