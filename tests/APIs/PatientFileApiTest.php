<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\PatientFile;

class PatientFileApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_patient_file()
    {
        $patientFile = factory(PatientFile::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/patient_files', $patientFile
        );

        $this->assertApiResponse($patientFile);
    }

    /**
     * @test
     */
    public function test_read_patient_file()
    {
        $patientFile = factory(PatientFile::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/patient_files/'.$patientFile->id
        );

        $this->assertApiResponse($patientFile->toArray());
    }

    /**
     * @test
     */
    public function test_update_patient_file()
    {
        $patientFile = factory(PatientFile::class)->create();
        $editedPatientFile = factory(PatientFile::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/patient_files/'.$patientFile->id,
            $editedPatientFile
        );

        $this->assertApiResponse($editedPatientFile);
    }

    /**
     * @test
     */
    public function test_delete_patient_file()
    {
        $patientFile = factory(PatientFile::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/patient_files/'.$patientFile->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/patient_files/'.$patientFile->id
        );

        $this->response->assertStatus(404);
    }
}
