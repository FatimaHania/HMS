<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Checkup;
use Illuminate\Support\Facades\DB;

/**
 * Class CheckupRepository.
 */
class CheckupRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Checkup::class;
    }

    public function getCheckupHistory($patient_id,$user_id)
    {

        $patient_id_arr = array();
        if($user_id == '' || $user_id == null || $user_id == '0'){ //get other patient_ids

            $user = DB::table('user_hospital')
                ->select('user_id')
                ->where([['user_link_id', '=' , $patient_id] , ['is_physician' , '=' , '0']])
                ->first(); 

                if(!empty($user)){
                    $user_id = $user->user_id;
                }

            $patient_id_arr[] = $patient_id;

        }

        $patient_ids = DB::table('user_hospital')
                ->select('user_link_id')
                ->where([['user_id' , '=' , $user_id] , ['is_physician' , '=' , '0']])
                ->whereNotNull('user_link_id')
                ->get();

        foreach($patient_ids as $pat_id){
            $patient_id_arr[] = $pat_id->user_link_id;
        }


        return Checkup::select('checkups.*' , 'checkups.id as checkup_id' , 'appointments.*' , 'sessions.*')
            ->whereIn('checkups.patient_id' , $patient_id_arr)
            ->join('appointments' , 'appointments.id' , '=' , 'checkups.appointment_id')
            ->join('sessions' , 'sessions.id' , '=' , 'appointments.session_id')
            ->orderBy('sessions.date','desc')
            ->orderBy('checkups.id','desc')
            ->get();

    }


    public function getCheckupRecord($checkup_id)
    {

        return Checkup::where('id' , $checkup_id)->first();

    }

    

}
