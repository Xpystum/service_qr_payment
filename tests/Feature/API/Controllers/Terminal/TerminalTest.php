<?php
namespace Tests\Feature\API\Controllers\Terminal;

use App\Modules\Organization\Models\Organization;
use App\Modules\Terminal\Models\Terminal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\Feature\Traits\AuthTraitTest;
use Tests\TestCase;

class TerminalTest extends TestCase
{
    use AuthTraitTest;

    public function test_get_terminal(): void
    {
        $org = $this->create_organization();
        $this->create_terminal($org);

        $response = $this
            ->withToken($this->userToken)
            ->get('/api/terminal/' . $org->uuid . '/terminals');


        if(empty($response->json('data'))) {

            //проверяем на пустой массив
            $this->assertEmpty($response->json('data'));

            $response->assertStatus(200)->assertJsonStructure([
                'data' => [],
                'message',

            ]);

        } else {

            $response->assertStatus(200)->assertJsonStructure([
                'data' => [
                    '*' => [
                        'name',
                        'uuid',
                        'organization_uuid',
                    ],
                ],
                'message',

            ]);

        }

    }

    public function test_create_terminal() : void{

        $org = $this->create_organization();

        $response = $this
            ->withToken($this->userToken)
            ->postJson('/api/terminal', [
                "name" => fake()->name(),
                'organization_uuid' => $org->uuid
            ]
        );

        $response->assertStatus(201)->assertJsonStructure([
            'data' => [
                'name',
                'uuid',
                'organization_uuid',
            ],
            'message',

        ]);


        $this->assertDatabaseHas('terminals', [
            'uuid' => Arr::get($response->json('data'), 'uuid'),
        ]);
    }

    public function test_show_terminal() : void
    {
        $terminal = $this->create_terminal();

        $response = $this
            ->withToken($this->userToken)
            ->get('/api/terminal/' . $terminal->uuid);

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'name',
                'uuid',
                'organization_uuid',
            ],
            'message',

        ]);

    }

    public function test_update_terminal() : void
    {
        $terminal = $this->create_terminal();

        $response = $this
            ->withToken($this->userToken)
            ->patchJson('/api/terminal/' . $terminal->uuid, [
                'name' => fake()->name(),
            ]);



        //проверяем на пустой массив
        $this->assertEmpty($response->json('data'));
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [],
            'message',
        ]);


        $this->assertDatabaseHas('terminals', [
            'uuid' => $terminal->uuid,
        ]);

    }

    public function test_delete_terminal() : void
    {
        $terminal = $this->create_terminal();

        $this->assertDatabaseHas('terminals', [
            'uuid' => $terminal->uuid,
        ]);

        $response = $this
            ->withToken($this->userToken)
            ->deleteJson('/api/terminal/' . $terminal->uuid, [
                'name' => fake()->name(),
            ]);


        //проверяем на пустой массив
        $this->assertEmpty($response->json('data'));
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [],
            'message',
        ]);



        $this->assertDatabaseMissing('terminals', [
            'uuid' => $terminal->uuid,
        ]);
    }


    private function create_organization() : Organization
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

    private function create_terminal(Organization $organization = null) : Terminal
    {
        if(is_null($organization)) { $organization = $this->create_organization(); }

        return $organization->terminals()->create([
            'name' => 'TestName'
        ]);

    }
}
