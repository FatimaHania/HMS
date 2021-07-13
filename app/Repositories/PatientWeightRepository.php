<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Illuminate\Support\Facades\DB;
use App\Models\PatientWeights;

/**
 * Class PatientWeightRepository.
 */
class PatientWeightRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return PatientWeights::class;
    }

    public function insertPatientWeight($patient_id , $date , $weight , $unit , $hospital_id , $branch_id)
    {

        return DB::insert('insert into patient_weights (patient_id, date, weight, unit, hospital_id, branch_id) values ('.$patient_id.', "'.$date.'", '.$weight.', "'.$unit.'", '.$hospital_id.', '.$branch_id.')');

    }

    public function getLastWeightRecord($patient_id)
    {

        return DB::table('patient_weights')->where('patient_id' , $patient_id)->orderBy('date','desc')->orderBy('id' , 'desc')->first();

    }


}
