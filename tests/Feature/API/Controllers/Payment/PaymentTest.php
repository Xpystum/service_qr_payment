<?php

namespace Tests\Feature\API\Controllers\Payment;

use Tests\Feature\Traits\AuthTraitTest;
use Tests\Feature\Traits\CreatePaymentTrait;
use Tests\Feature\Traits\CreateTransactionTrait;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use AuthTraitTest, CreatePaymentTrait;

    public function test_get_payment()
    {
        {
            //создаём payment
            $payment = $this->create_payment();
        }

            $response = $this
                ->withToken($this->userToken)
                ->get('/api/payment/' . $payment->uuid);

            $response->assertStatus(200)->assertJsonStructure([
                'data' => [
                    'uuid',
                    'created_at',
                    'updated_at',
                    'status',
                    'amount',
                    'driver',
                    'pyable_name',
                ],
                'message',
            ]);
    }

    public function test_get_paymentMethods()
    {
        $this->installCurrensies();
        $this->installPaymentMethod();

        $response = $this
            ->withToken($this->userToken)
            ->get('/api/payment/');

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'created_at',
                    'updated_at',
                    'name',
                    'driver',
                    'active',
                    'driver_currency_id',
                ],
            ],
            'message',
        ]);
    }
}
