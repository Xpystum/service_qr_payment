<?php
namespace App\Modules\User\Actions\PersonalAreas;

use App\Modules\User\Models\PersonalArea;
use App\Modules\User\Models\User;
use App\Patterns\Handlers\AbstractHandler;
use Illuminate\Support\Facades\DB;


class CreatePersonalAreaAction extends AbstractHandler
{
    /**
     * Summary of process
     * @param User $data
     * @return ?PersonalArea
     */
    protected function process($data)
    {
        return $this->run($data);
    }

    public static function make() : self
    {
        return new self();
    }
    public static function run(User $data) : ?PersonalArea
    {
        /**
        * @var \App\Modules\User\Enums\RoleUserEnum
        */
        $enum = $data->role;

        if($enum->isAdmin())
        {

            $personalArea = DB::transaction(function () use ($data) {
                return PersonalArea::firstOrCreate(['owner_id' => $data->id]);
            });

            return $personalArea;

        } else {

            return null;

        }

    }

}
