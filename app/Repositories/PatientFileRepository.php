<?php

namespace App\Repositories;

use App\Models\PatientFile;
use App\Models\Patient;
use App\Models\Department;
use App\Models\Disease;
use App\Repositories\BaseRepository;

/**
 * Class PatientFileRepository
 * @package App\Repositories
 * @version October 15, 2020, 6:08 pm UTC
*/

class PatientFileRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'file_name',
        'description',
        'patient_id',
        'department_id',
        'disease_id',
        'is_active',
        'hospital_id',
        'branch_id'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PatientFile::class;
    }

    public function getAll()
    {
        return PatientFile::orderBy('created_at', 'DESC')->with(['patient','department','disease'])->get();
    }


    public function getPatients() 
    {
        $patients = Patient::orderBy('patient_number', 'ASC')->get();
        return $patients;
    }

    public function getDepartments() 
    {
        $departments = Department::orderBy('description', 'ASC')->pluck('description' , 'id');
        return $departments;
    }

    public function getDiseases() 
    {
        $diseases = Disease::orderBy('description', 'ASC')->pluck('description' , 'id');
        return $diseases;
    }

    public function getPatientFiles($patientId) 
    {
        $patientFiles = PatientFile::where(['patient_id' => $patientId])->orderBy('created_at', 'DESC')->get();
        return $patientFiles;
    }


}
