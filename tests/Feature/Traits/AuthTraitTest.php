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

    //проверяем в каждых test, на авторизацию user
    public function test_authorize_user()
    {
        $response = $this
            ->withToken($this->userToken)
            ->get('/api/auth/me');

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'uuid',
                'email',
                'phone',
                'first_name',
                'last_name',
                'father_name',
                'auth',
                'role',
            ],
            'message',
        ]);
    }
}
