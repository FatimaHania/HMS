<?php namespace Tests\Repositories;

use App\Models\Title;
use App\Repositories\TitleRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class TitleRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var TitleRepository
     */
    protected $titleRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->titleRepo = \App::make(TitleRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_title()
    {
        $title = factory(Title::class)->make()->toArray();

        $createdTitle = $this->titleRepo->create($title);

        $createdTitle = $createdTitle->toArray();
        $this->assertArrayHasKey('id', $createdTitle);
        $this->assertNotNull($createdTitle['id'], 'Created Title must have id specified');
        $this->assertNotNull(Title::find($createdTitle['id']), 'Title with given id must be in DB');
        $this->assertModelData($title, $createdTitle);
    }

    /**
     * @test read
     */
    public function test_read_title()
    {
        $title = factory(Title::class)->create();

        $dbTitle = $this->titleRepo->find($title->id);

        $dbTitle = $dbTitle->toArray();
        $this->assertModelData($title->toArray(), $dbTitle);
    }

    /**
     * @test update
     */
    public function test_update_title()
    {
        $title = factory(Title::class)->create();
        $fakeTitle = factory(Title::class)->make()->toArray();

        $updatedTitle = $this->titleRepo->update($fakeTitle, $title->id);

        $this->assertModelData($fakeTitle, $updatedTitle->toArray());
        $dbTitle = $this->titleRepo->find($title->id);
        $this->assertModelData($fakeTitle, $dbTitle->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_title()
    {
        $title = factory(Title::class)->create();

        $resp = $this->titleRepo->delete($title->id);

        $this->assertTrue($resp);
        $this->assertNull(Title::find($title->id), 'Title should not exist in DB');
    }
}
