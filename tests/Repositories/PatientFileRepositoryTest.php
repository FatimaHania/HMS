<?php namespace Tests\Repositories;

use App\Models\PatientFile;
use App\Repositories\PatientFileRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class PatientFileRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var PatientFileRepository
     */
    protected $patientFileRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->patientFileRepo = \App::make(PatientFileRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_patient_file()
    {
        $patientFile = factory(PatientFile::class)->make()->toArray();

        $createdPatientFile = $this->patientFileRepo->create($patientFile);

        $createdPatientFile = $createdPatientFile->toArray();
        $this->assertArrayHasKey('id', $createdPatientFile);
        $this->assertNotNull($createdPatientFile['id'], 'Created PatientFile must have id specified');
        $this->assertNotNull(PatientFile::find($createdPatientFile['id']), 'PatientFile with given id must be in DB');
        $this->assertModelData($patientFile, $createdPatientFile);
    }

    /**
     * @test read
     */
    public function test_read_patient_file()
    {
        $patientFile = factory(PatientFile::class)->create();

        $dbPatientFile = $this->patientFileRepo->find($patientFile->id);

        $dbPatientFile = $dbPatientFile->toArray();
        $this->assertModelData($patientFile->toArray(), $dbPatientFile);
    }

    /**
     * @test update
     */
    public function test_update_patient_file()
    {
        $patientFile = factory(PatientFile::class)->create();
        $fakePatientFile = factory(PatientFile::class)->make()->toArray();

        $updatedPatientFile = $this->patientFileRepo->update($fakePatientFile, $patientFile->id);

        $this->assertModelData($fakePatientFile, $updatedPatientFile->toArray());
        $dbPatientFile = $this->patientFileRepo->find($patientFile->id);
        $this->assertModelData($fakePatientFile, $dbPatientFile->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_patient_file()
    {
        $patientFile = factory(PatientFile::class)->create();

        $resp = $this->patientFileRepo->delete($patientFile->id);

        $this->assertTrue($resp);
        $this->assertNull(PatientFile::find($patientFile->id), 'PatientFile should not exist in DB');
    }
}
