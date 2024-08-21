<?php
namespace Tests\Feature\API\Controllers\User;

use App\Modules\User\Actions\Handler\CreateUserHandler;
use App\Modules\User\DTO\CreatUserDTO;
use App\Modules\User\DTO\ValueObject\User\UserVO;
use Tests\Feature\Traits\AuthTraitTest;
use Tests\TestCase;

class UserTest extends TestCase
{
    use AuthTraitTest;

    //проверка на авторизацию
    public function test_authorized_user_can_access_user()
    {

        $response = $this
            ->withToken($this->userToken)
            ->get('/api/user');

        $response->assertStatus(200);
    }

    //получение users
    public function test_get_user(): void
    {
        {

            $response = $this
            ->withToken($this->userToken)
            ->get('/api/user');

            $response->assertStatus(200)->assertJsonStructure([
                'data' => [
                    '*' => [
                        'uuid',
                        'email',
                        'phone',
                        'first_name',
                        'last_name',
                        'father_name',
                        'role',
                        'auth',
                    ],
                ],
                'message',
            ]);


            if(empty($response->json('data'))) {
                //проверяем на пустой массив
                $this->assertEmpty($response->json('data'));
            }
        }

    }

    //создание users по email
    public function test_create_user_email() : void
    {

        $this->user->personalArea()->create([
            'owner_id' => $this->user->id
        ]);

        $email = fake()->unique()->safeEmail();

        $response = $this
            ->withToken($this->userToken)
            ->postJson('/api/user', [
                "email" => $email,
                "role" =>  "manager",
                "password" =>  "Pas123!",
                "password_confirmation" =>  "Pas123!",
                "agreement" =>  true
            ]);

        {
            $response->assertStatus(201)->assertJsonStructure([
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


            $this->assertDatabaseHas('users', [
                'email' => $email,
            ]);
        }

    }

    //создание users по phone
    public function test_create_user_phone() : void
    {

        $this->user->personalArea()->create([
            'owner_id' => $this->user->id
        ]);

        $phone = '+79200746532';

        $response = $this
            ->withToken($this->userToken)
            ->postJson('/api/user', [
                "phone" => $phone,
                "role" =>  "manager",
                "password" =>  "Pas123!",
                "password_confirmation" =>  "Pas123!",
                "agreement" =>  true
            ]);


        {

            $response->assertStatus(201)->assertJsonStructure([
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

            $this->assertDatabaseHas('users', [
                'phone' => $phone,
            ]);
        }

    }

    public function test_update_user()
    {

        $email = fake()->unique()->safeEmail();

        $response = $this
            ->withToken($this->userToken)
            ->putJson('/api/user', [
                "uuid" => $this->user->uuid,
                "email" => $email,
                "first_name" =>  fake()->name(),
                "last_name" =>  fake()->firstName(),
                "father_name" =>  fake()->firstNameMale(),
        ]);


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
        ]);

        $this->assertDatabaseHas('users', [
            'uuid' => $this->user->uuid,
            'email' => $email,
        ]);

    }

    public function test_delete_user()
    {
        {
            $personalArea = $this->user->personalArea()->create([
                'owner_id' => $this->user->id
            ]);

            /**
            * @var CreateUserHandler
            */
            $handlers = app(CreateUserHandler::class);

            /**
            * @var UserVO
            */
            $userVO = UserVO::fromArray([
                'email' => fake()->unique()->safeEmail(),
                'phone' => null,
                'password' => 'Pas123!',
                'role' => 'manager',
            ]);

            $userCreate = $handlers->handle(CreatUserDTO::make($userVO, $personalArea->id));
        }


        $response = $this
            ->withToken($this->userToken)
            ->deleteJson('/api/user', [
                "uuid" => $userCreate->uuid,
        ]);


        $response->assertStatus(200)->assertJsonStructure([
            'data' => [],
            'message',
        ]);


        $this->assertDatabaseMissing('users', [
            'uuid' => $userCreate->uuid,
        ]);
    }

}
