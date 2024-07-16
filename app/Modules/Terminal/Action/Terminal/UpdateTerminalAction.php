<?php

namespace App\Modules\Terminal\Action\Terminal;

use App\Modules\Organization\Models\Organization;
use App\Modules\Terminal\Models\Terminal;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateTerminalAction
{

    private string $name;

    public function name(?string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    public function run(Terminal $terminal) : bool
    {

        $terminal->name = $this->name;

        if(!$terminal->save()){
            throw new ModelNotFoundException('Не удалось создать терминал.', 500);
        } else {
            return true;
        }

    }
}
