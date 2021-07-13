<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Illuminate\Support\Facades\DB;
use App\Models\PatientHeights;

/**
 * Class PatientHeightRepository.
 */
class PatientHeightRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return PatientHeights::class;
    }

    public function insertPatientHeight($patient_id , $date , $height , $unit , $hospital_id , $branch_id)
    {

        return DB::insert('insert into patient_heights (patient_id, date, height, unit, hospital_id, branch_id) values ('.$patient_id.', "'.$date.'", '.$height.', "'.$unit.'", '.$hospital_id.', '.$branch_id.')');

    }


    public function getLastHeightRecord($patient_id)
    {

        return DB::table('patient_heights')->where('patient_id' , $patient_id)->orderBy('date','desc')->orderBy('id' , 'desc')->first();

    }

}
