<?php

namespace App\Http\Controllers\Api\Organization\Create;

use App\Http\Controllers\Controller;
use App\Modules\Organization\Requests\CreteOrganizationRequest;
use Illuminate\Http\Request;

class OrganizationCreateController extends Controller
{
    public function __invoke(CreteOrganizationRequest $request)
    {
        $validated = $request->validated();

        dd($validated);
    }
}
