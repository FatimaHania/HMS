<?php 

namespace App\Helpers;

use App\Models\DocumentCode;
use App\Models\Patient;
use App\Models\Physician;
use App\Models\Nurse;
use App\Models\Appointment;

class Helper
{
    public static function documentCode($documentCodeId)
    {
        
        $documentCode = "";
        $serialNumber = "";
        $documentCodeDetails = DocumentCode::where('documentcode_id',$documentCodeId)->first();

        if(!empty($documentCodeDetails)){

            $prefix = $documentCodeDetails->prefix;
            $starting_no = $documentCodeDetails->starting_no;
            $format_length = $documentCodeDetails->format_length;
            $common_difference = $documentCodeDetails->common_difference;

            if($documentCodeId == '1'){ //patient module
                $lastRecord = Patient::orderBy('patient_number', 'DESC')->first();

                if(!empty($lastRecord)){
                    $lastSerialNo = $lastRecord->patient_number;
                } 
            } else if($documentCodeId == '2'){ //physician module
                $lastRecord = Physician::orderBy('physician_number', 'DESC')->first();

                if(!empty($lastRecord)){
                    $lastSerialNo = $lastRecord->physician_number;
                } 
            } else if($documentCodeId == '3'){ //nurse module
                $lastRecord = Nurse::orderBy('nurse_number', 'DESC')->first();

                if(!empty($lastRecord)){
                    $lastSerialNo = $lastRecord->nurse_number;
                } 
            }else if($documentCodeId == '4'){ //appointment module
                $lastRecord = Appointment::orderBy('reference_number', 'DESC')->first();

                if(!empty($lastRecord)){
                    $lastSerialNo = $lastRecord->reference_number;
                } 
            } 

            if(isset($lastSerialNo)){
                $serialNumber = ($lastSerialNo+$common_difference);
            } else {
                $serialNumber = $starting_no;
            }

            $documentCode = $prefix.(sprintf('%0'.$format_length.'d', $serialNumber));

        } 

        return array(
            'serial_number' => $serialNumber,
            'document_code' => $documentCode
        );


    }
}