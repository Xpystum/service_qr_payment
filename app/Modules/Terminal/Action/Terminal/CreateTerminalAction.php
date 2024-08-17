<?php

namespace App\Modules\Terminal\Action\Terminal;

use App\Modules\Organization\Models\Organization;
use App\Modules\Terminal\DTO\CreateTerminalDTO;
use App\Modules\Terminal\DTO\ValueObject\TerminalVO;
use App\Modules\Terminal\Models\Terminal;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateTerminalAction
{
    public static function make() : self
    {
        return new self();
    }

    public static function run(CreateTerminalDTO $data) : Terminal
    {
        $terminal = Terminal::create([
            'name' =>  $data->terminalVO->name,
            'organization_id' => $data->organization->id,
        ]);

        if(!$terminal->save()){
            throw new ModelNotFoundException('Не удалось создать терминал.', 500);
        }

        return $terminal;
    }
}
