<?php
namespace Tests\Feature\Traits;

use App\Modules\Organization\Models\Organization;

trait CreateOrganizationTrait
{
    protected function create_organization() : Organization
    {
        /**
         * @var Organization
         */
        return $this->user->organizations()->create([
            "name" => "name org2",
            "address" => "yl comment Moscow",
            "phone_number" => "79288574635",
            "email" => "test@mail.ru",
            "website" => "webbsite",
            "founded_date" => "2021-10-05",
            "industry" => "IT",
            "type" => "Индивидуальный Предприниматель",
            "description" => "sdfgsdg",
            "inn" => "7743013904",
            "registration_number_individual" => "316861700133226"
        ]);
    }


}
