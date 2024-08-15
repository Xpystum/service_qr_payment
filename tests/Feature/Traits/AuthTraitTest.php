<?php

namespace Tests\Feature\Traits;

use App\Modules\User\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Support\Arr;

trait AuthTraitTest
{
    protected $auth;

    protected $userToken;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->user = $user;

        //Создание тестовой БД - если её нет.
        $this->auth = app(AuthService::class);

        $this->userToken = Arr::get($this->auth->loginUser($user), 'access_token', null);
    }
}
