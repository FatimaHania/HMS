<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Currency;

class CurrencyApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_currency()
    {
        $currency = factory(Currency::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/currencies', $currency
        );

        $this->assertApiResponse($currency);
    }

    /**
     * @test
     */
    public function test_read_currency()
    {
        $currency = factory(Currency::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/currencies/'.$currency->id
        );

        $this->assertApiResponse($currency->toArray());
    }

    /**
     * @test
     */
    public function test_update_currency()
    {
        $currency = factory(Currency::class)->create();
        $editedCurrency = factory(Currency::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/currencies/'.$currency->id,
            $editedCurrency
        );

        $this->assertApiResponse($editedCurrency);
    }

    /**
     * @test
     */
    public function test_delete_currency()
    {
        $currency = factory(Currency::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/currencies/'.$currency->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/currencies/'.$currency->id
        );

        $this->response->assertStatus(404);
    }
}
