<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeModules extends Command
{


    public const FOLDERS = ['Action', 'Repositories', 'DTO', 'Models', 'Requests', 'Resources'];

    protected $signature = 'make:module';

    protected $description = 'Создание структуры папок Модуля (Module)';

    public function handle()
    {

        $nameModule = $this->ask("Установите название Модуля:");
        $path = base_path("app/Modules/".$nameModule);

        File::makeDirectory($path, 0777, true);

        foreach(self::FOLDERS as $folder){
            File::makeDirectory($path . '/' . $folder);
        }


    }
}
