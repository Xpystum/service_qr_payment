<?php

namespace Tests\Feature\API\Controllers\Transaction;

use App\Modules\Payment\Enums\PaymentDriverEnum;
use App\Modules\Payment\Models\PaymentMethod;
use Tests\Feature\Traits\CreatePaymentTrait;
use Illuminate\Support\Arr;
use Tests\Feature\Traits\AuthTraitTest;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use AuthTraitTest, CreatePaymentTrait;


    /**
     * Вернуть все транзакции по терминалу
     * @return void
     */
    public function test_getAll_transaction(): void
    {
        $terminal = $this->create_terminal();

        {
            //создаём 3-транзакции для теста
            $this->create_transaction($terminal);
            $this->create_transaction($terminal);
            $this->create_transaction($terminal);
        }

        $response = $this
            ->withToken($this->userToken)
            ->get('/api/transaction/' . $terminal->uuid . '/all');


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
                        'driver_currency_id',
                        'amount',
                        'uuid',
                        'status',
                        'created_at',
                    ],
                ],
                'message',
            ]);

        }
    }
    public function test_getPagination_transaction() : void
    {
        $terminal = $this->create_terminal();

        {
            //создаём 3-транзакции для теста
            $this->create_transaction($terminal);
            $this->create_transaction($terminal);
            $this->create_transaction($terminal);
        }

        $response = $this
            ->withToken($this->userToken)
            ->get('/api/transaction/' . $terminal->uuid . '/pagination');


        if(empty($response->json('data'))) {

            //проверяем на пустой массив
            $this->assertEmpty($response->json('data'));

            $response->assertStatus(200)->assertJsonStructure([
                'data' => [],
                'message',

            ]);

        } else {

            $response->assertStatus(200)->assertJsonStructure([
                'data' => [] ,
                'message',
            ]);

        }
    }

    public function tets_get_transaction() : void
    {
        $transaction = $this->create_transaction();

        $response = $this
            ->withToken($this->userToken)
            ->get('/api/transaction/' . $transaction->uuid);

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                '*' => [
                    'driver_currency_id',
                    'amount',
                    'uuid',
                    'status',
                    'created_at',
                ],
            ],
            'message',
        ]);

    }

    public function test_create_transaction() : void
    {

        {
            $terminal = $this->create_terminal();
            $this->installCurrensies();
        }


        $response = $this
            ->withToken($this->userToken)
            ->postJson('/api/transaction', [
                "amount" => fake()->numberBetween(100, 10000),
                'terminal_uuid' => $terminal->uuid,
            ]
        );

        $response->assertStatus(201)->assertJsonStructure([
            'data' => [
                'driver_currency_id',
                'amount',
                'uuid',
                'status',
                'created_at',
            ],
            'message',
        ]);


        $this->assertDatabaseHas('transactions', [
            'uuid' => Arr::get($response->json('data'), 'uuid'),
        ]);
    }

    public function test_create_payment() : void
    {

        {
            $transaction = $this->create_transaction();
            $this->installPaymentMethod();
        }

        $response = $this
            ->withToken($this->userToken)
            ->postJson('/api/transaction/' . $transaction->uuid . '/payment', [
                "method_id" => PaymentMethod::where('active', true)->first()->id,
            ]
        );

        $response->assertStatus(201)->assertJsonStructure([
            'data' => [
                'uuid',
                'created_at',
                'updated_at',
                'status',
                'amount',
                'driver',
            ],
            'message',
        ]);


        $this->assertDatabaseHas('payments', [
            'uuid' => Arr::get($response->json('data'), 'uuid'),
        ]);
    }

    public function test_get_payment() : void
    {
        $transaction = $this->create_transaction();
        $this->create_payment($transaction);

        $response = $this
            ->withToken($this->userToken)
            ->get('/api/transaction/' . $transaction->uuid . '/payment');


        $response->assertStatus(200)->assertJsonStructure([
            'data' => [

                '*' => [
                    'uuid',
                    'created_at',
                    'updated_at',
                    'status',
                    'amount',
                    'driver',
                ],

            ],
            'message',
        ]);
    }

    public function test_install_currensies_consoleCommand()
    {
        $this->artisan('currencies:install')
             ->assertExitCode(0) // Проверяем код выхода (0 - без ошибок)
             ->expectsOutput('Валюты установлены.'); // Проверяем вывод

        // Проверяем, что пользователь был создан в базе данных
        $this->assertDatabaseHas('currencies', ['id' => 'RUB']);
    }

    public function test_install_paymentMethod_consoleCommand()
    {
        $this->installCurrensies();

        $this->artisan('payments:install')
             ->assertExitCode(0) // Проверяем код выхода (0 - без ошибок)
             ->expectsOutput('Платежные системы установлены.'); // Проверяем вывод

        // Проверяем, что пользователь был создан в базе данных
        $this->assertDatabaseHas('payment_methods', [
            'driver' => PaymentDriverEnum::test,
        ]);

        $this->assertDatabaseHas('payment_methods', [
            'driver' => PaymentDriverEnum::ykassa,
        ]);
    }


}
