<?php
namespace App\Modules\Terminal\Action\Terminal;

use App\Modules\Terminal\Models\Terminal;
use Exception;


use function App\Helpers\Mylog;

class DeletedTerminalAction
{
    public function run(Terminal $termianl) : bool
    {
        try {

            $status = $termianl->delete();

        } catch (\Throwable $th) {
            MyLog('удаление из таблицы {Organization} выдало ошибку');
            throw new Exception('Ошибка удаление из таблицы {Organization}', 500);
        }

        return ($status > 0) ? true : false;
    }
}
