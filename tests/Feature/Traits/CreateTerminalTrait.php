<?php

namespace Tests\Feature\Traits;

use App\Modules\Organization\Models\Organization;
use App\Modules\Terminal\Models\Terminal;

trait CreateTerminalTrait
{

    use CreateOrganizationTrait;
    protected function create_terminal(Organization $organization = null) : Terminal
    {
        if(is_null($organization)) { $organization = $this->create_organization(); }

        return $organization->terminals()->create([
            'name' => 'TestName'
        ]);

    }
}
