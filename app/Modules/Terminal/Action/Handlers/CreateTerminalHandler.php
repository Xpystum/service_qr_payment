<?php

namespace App\Modules\Terminal\Action\Handlers;

use App\Modules\Organization\Repositories\OrganizationRepositories;
use App\Modules\Terminal\Action\Terminal\CreateTerminalAction;
use App\Modules\Terminal\DTO\CreateTerminalDTO;
use App\Modules\Terminal\DTO\ValueObject\TerminalVO;
use App\Modules\Terminal\Models\Terminal;

class CreateTerminalHandler
{
    public function handle(TerminalVO $data) : ?Terminal
    {
        $terminalCreateAction = CreateTerminalAction::make();
        $organizationRepository = OrganizationRepositories::make();

        {
            $organization = $organizationRepository->uuidOrganization($data->organization_uuid);
            abort_unless((bool) $organization, 404,  'Ресурс по uuid не был найден.');
        }

        $modelTerminal = $terminalCreateAction::run(CreateTerminalDTO::make($data, $organization));

        return $modelTerminal;
    }
}
