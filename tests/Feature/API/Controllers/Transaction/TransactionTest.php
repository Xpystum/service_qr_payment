<?php

namespace Tests\Feature\API\Controllers\Transaction;

use App\Modules\Organization\Models\Organization;
use App\Modules\Payment\Action\Handler\CreatePaymentHandler;
use App\Modules\Payment\Drivers\Ykassa\Database\Enums\PaymentStatusEnum;
use App\Modules\Payment\DTO\CreatePaymentDTO;
use App\Modules\Payment\Enums\PaymentDriverEnum;
use App\Modules\Payment\Models\Payment;
use App\Modules\Payment\Models\PaymentMethod;
use App\Modules\Terminal\Models\Terminal;
use App\Modules\Transactions\Enums\TransactionStatusEnum;
use App\Modules\Transactions\Models\Transaction;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Tests\Feature\Traits\AuthTraitTest;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use AuthTraitTest;
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

    private function installPaymentMethod() : bool
    {
        $exitCode = Artisan::call('payments:install');

        $this->assertTrue(
            $exitCode == 0 ? true : false,
            "Ошибка при установке валют комманда: {payments:install}"
        );


        return $exitCode == 0 ? true : false;
    }

    private function installCurrensies() : bool
    {
        $exitCode = Artisan::call('currencies:install');

        $this->assertTrue(
            $exitCode == 0 ? true : false,
            "Ошибка при установке валют комманда: {currencies:install}"
        );


        return $exitCode == 0 ? true : false;
    }


    private function create_transaction(Terminal $terminal = null) : Transaction
    {
        $this->installCurrensies();

        if(is_null($terminal)) { $terminal = $this->create_terminal(); }

        $transaction = $terminal->transaction()->create([
            'status' => TransactionStatusEnum::pending,
            'driver_currency_id' => 'RUB',
            'amount' => fake()->numberBetween(10 , 1000),
        ]);

        $this->assertDatabaseHas('transactions', [
            'uuid' => $transaction->uuid,
        ]);



        return $transaction;
    }


    private function create_payment(Transaction $transaction = null) : Payment
    {
        {
            if(is_null($transaction)) { $transaction = $this->create_transaction(); }
            $this->installPaymentMethod();
            $paymentMethod = PaymentMethod::where('active', true)->first();
        }

        $handler = CreatePaymentHandler::make();

        $payment = $handler->handle(CreatePaymentDTO::make($transaction, $paymentMethod->id));

        return $payment;
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
