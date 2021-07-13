<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PhysicianRepository;
use App\Repositories\AppointmentRepository;
use App\Repositories\DepartmentRepository;
use PDF;

class PatientTurnoverController extends Controller
{

    /** @var  PhysicianRepository */
    /** @var  AppointmentRepository */
    /** @var  DepartmentRepository */
    private $physicianRepository;
    private $appointmentRepository;
    private $departmentRepository;

    public function __construct(PhysicianRepository $physicianRepo, AppointmentRepository $appointmentRepo, DepartmentRepository $departmentRepo)
    {
        $this->physicianRepository = $physicianRepo;
        $this->appointmentRepository = $appointmentRepo;
        $this->departmentRepository = $departmentRepo;
    }

    /**
     * 
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {

        $physicians = $this->physicianRepository->getAll();
        $departments = $this->departmentRepository->all();

        $date_from = date('Y-m-d');
        $date_to = date('Y-m-d');
        $patient_tunrover_records = $this->appointmentRepository->getPatientTurnover('daily',$date_from, $date_to, '0', '0');

        return view('reports.patient_turnover.index')
            ->with('physicians', $physicians)
            ->with('departments', $departments)
            ->with('records', $patient_tunrover_records);
    }

    /** 
     * Update Physician Filter 
     * */

    public function updatePhysicianFilter()
    {

        $department_id = $_POST['department_id'];

        return $this->physicianRepository->updatePhysicianFilter($department_id);

    }


    /** 
     * Get Patient Turnover records 
     * */
    public function getPatientTurnover()
    {

        $type = $_POST['type'];
        $date_from = $_POST['date_from'];
        $date_to = $_POST['date_to'];
        $physician_id = $_POST['physician_id'];
        $department_id = $_POST['department_id'];

        $records = $this->appointmentRepository->getPatientTurnover($type,$date_from, $date_to, $physician_id, $department_id);

        if($type == 'daily'){
            return view('reports.patient_turnover.table_daily')
                ->with('records', $records);
        } else if($type == 'monthly'){
            return view('reports.patient_turnover.table_monthly')
                ->with('records', $records);
        } else if($type == 'yearly'){
            return view('reports.patient_turnover.table_yearly')
                ->with('records', $records);
        }

    }


    /** 
     * Generate PDF 
     * */
    public function PDFPatientTurnoverReport()
    {

        $type = $_POST['filter_type'];
        $date_from = $_POST['filter_date_from'];
        $date_to = $_POST['filter_date_to'];
        $physician_id = $_POST['filter_physician'];
        $department_id = $_POST['filter_department'];

        if($type == 'daily'){

            $records = $this->appointmentRepository->getPatientTurnover($type,$date_from, $date_to, $physician_id, $department_id);

            $pdf = PDF::loadView('reports.patient_turnover.pdf_daily', compact('records'));
    
            return $pdf->download('patient_turnover_daily_report.pdf');

        } else if ($type == 'monthly'){

            $records = $this->appointmentRepository->getPatientTurnover($type,$date_from, $date_to, $physician_id, $department_id);

            $pdf = PDF::loadView('reports.patient_turnover.pdf_monthly', compact('records'));
    
            return $pdf->download('patient_turnover_monthly_report.pdf');

        } else if ($type == 'yearly'){

            $records = $this->appointmentRepository->getPatientTurnover($type,$date_from, $date_to, $physician_id, $department_id);

            $pdf = PDF::loadView('reports.patient_turnover.pdf_yearly', compact('records'));
    
            return $pdf->download('patient_turnover_annual_report.pdf');

        }

    }


}
