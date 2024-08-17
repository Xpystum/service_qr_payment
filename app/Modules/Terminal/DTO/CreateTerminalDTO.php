<?php

namespace App\Modules\Terminal\DTO;

use App\Modules\Organization\Models\Organization;
use App\Modules\Terminal\DTO\ValueObject\TerminalVO;

class CreateTerminalDTO
{
    public function __construct(
        public readonly TerminalVO $terminalVO,
        public readonly Organization $organization,
    ) {}

    public static function make(TerminalVO $terminalVO, Organization $organization) : self
    {
        return new self(
            terminalVO: $terminalVO,
            organization: $organization,
        );
    }

}
