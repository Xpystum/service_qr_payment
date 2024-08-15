<?php

namespace App\Modules\User\Actions\PersonalAreas;
use App\Modules\User\Models\PersonalArea;
use App\Modules\User\Models\User;
use App\Patterns\Handlers\AbstractHandler;
use Illuminate\Support\Facades\DB;


class CreatePersonalArea extends AbstractHandler
{

    /**
     * @param User $data
     *
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
    public static function run(User $user) : ?PersonalArea
    {


        if($user->role->isAdmin())
        {
            return DB::transaction(function () use ($user) {

                return PersonalArea::firstOrCreate(['owner_id' => $user->id]);

            });

        } else {

            return null;

        }

    }

}
