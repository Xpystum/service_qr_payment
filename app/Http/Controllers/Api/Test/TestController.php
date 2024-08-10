<?php

namespace App\Http\Controllers\Api\Test;

use App\Http\Controllers\Controller;
use App\Modules\User\Models\User;
use App\Modules\User\Resources\UserResource;
use App\Services\Auth\Traits\TraitController;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestController extends Controller
{
    use RefreshDatabase;

    use TraitController;

    public function index()
    {
        $user = User::factory()->count(4)->create();
        return UserResource::collection(User::paginate());
    }

}
