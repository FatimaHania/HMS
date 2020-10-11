<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




Route::resource('titles', 'TitleAPIController');

Route::resource('genders', 'GenderAPIController');

Route::resource('nationalities', 'NationalityAPIController');

Route::resource('countries', 'CountryAPIController');

Route::resource('bloodgroups', 'BloodgroupAPIController');

Route::resource('patients', 'PatientAPIController');

Route::resource('document_codes', 'DocumentCodeAPIController');

Route::resource('hospitals', 'HospitalAPIController');

Route::resource('branches', 'BranchAPIController');

Route::resource('physicians', 'PhysicianAPIController');





Route::resource('nurses', 'NurseAPIController');

Route::resource('specializations', 'SpecializationAPIController');

Route::resource('departments', 'DepartmentAPIController');

Route::resource('diseases', 'DiseaseAPIController');

Route::resource('treatments', 'TreatmentAPIController');

Route::resource('currencies', 'CurrencyAPIController');



Route::resource('designations', 'DesignationAPIController');

Route::resource('rooms', 'RoomAPIController');

Route::resource('department_rooms', 'DepartmentRoomAPIController');

Route::resource('sessions', 'SessionAPIController');