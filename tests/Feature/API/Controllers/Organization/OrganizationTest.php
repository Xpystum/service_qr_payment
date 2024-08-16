<?php

namespace Tests\Feature\Feature\API\Controllers\Organization;

use App\Modules\Organization\Models\Organization;
use Tests\Feature\Traits\AuthTraitTest;
use Tests\TestCase;

class OrganizationTest extends TestCase
{

    use AuthTraitTest;
    /**
     * A basic feature test example.
     */
    public function test_get_organization(): void
    {

        /**
         * @var Organization
         */
        $this->user->organizations()->create([
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

        $response = $this
            ->withToken($this->userToken)
            ->get('/api/organization');

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                '*' => [
                    'uuid',
                    'name',
                    'owner_id' ,
                    'address',
                    'phone_number',
                    'email',
                    'website',
                    'type',
                    'description',
                    'industry',
                    'founded_date',
                    'inn' ,
                    'registration_number_individual',
                ],
            ],
            'message',
        ]);

        if(empty($response->json('data'))) {
            //проверяем на пустой массив
            $this->assertEmpty($response->json('data'));
        }

    }

    public function test_create_organization() : void
    {

        $response = $this
            ->withToken($this->userToken)
            ->postJson('/api/organization', [
                "name" => fake()->name(),
                "address" => fake()->address(),
                "phone_number" => fake()->phoneNumber(),
                "email" => fake()->safeEmail(),
                "website" => fake()->domainName(),
                "founded_date" => fake()->date('Y-m-d', 'now'),
                "industry" => fake()->word(),
                "type" => "Индивидуальный Предприниматель",
                "description" => fake()->sentence(),
                "inn" => fake()->numerify('##########'),
                "registration_number_individual" => "316861700133226"
            ]);

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'uuid',
                'name',
                'owner_id' ,
                'address',
                'phone_number',
                'email',
                'website',
                'type',
                'description',
                'industry',
                'founded_date',
                'inn' ,
                'registration_number_individual',
            ],
            'message',
        ]);

        dd($response->json('data'));

        $this->assertDatabaseHas('organizations', [
            'uuid' => $response->json('data'),
        ]);
    }
}
