<?php namespace Tests\Repositories;

use App\Models\Currency;
use App\Repositories\CurrencyRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CurrencyRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CurrencyRepository
     */
    protected $currencyRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->currencyRepo = \App::make(CurrencyRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_currency()
    {
        $currency = factory(Currency::class)->make()->toArray();

        $createdCurrency = $this->currencyRepo->create($currency);

        $createdCurrency = $createdCurrency->toArray();
        $this->assertArrayHasKey('id', $createdCurrency);
        $this->assertNotNull($createdCurrency['id'], 'Created Currency must have id specified');
        $this->assertNotNull(Currency::find($createdCurrency['id']), 'Currency with given id must be in DB');
        $this->assertModelData($currency, $createdCurrency);
    }

    /**
     * @test read
     */
    public function test_read_currency()
    {
        $currency = factory(Currency::class)->create();

        $dbCurrency = $this->currencyRepo->find($currency->id);

        $dbCurrency = $dbCurrency->toArray();
        $this->assertModelData($currency->toArray(), $dbCurrency);
    }

    /**
     * @test update
     */
    public function test_update_currency()
    {
        $currency = factory(Currency::class)->create();
        $fakeCurrency = factory(Currency::class)->make()->toArray();

        $updatedCurrency = $this->currencyRepo->update($fakeCurrency, $currency->id);

        $this->assertModelData($fakeCurrency, $updatedCurrency->toArray());
        $dbCurrency = $this->currencyRepo->find($currency->id);
        $this->assertModelData($fakeCurrency, $dbCurrency->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_currency()
    {
        $currency = factory(Currency::class)->create();

        $resp = $this->currencyRepo->delete($currency->id);

        $this->assertTrue($resp);
        $this->assertNull(Currency::find($currency->id), 'Currency should not exist in DB');
    }
}
