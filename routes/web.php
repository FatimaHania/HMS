<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



//Home
Route::get('/home', 'HomeController@index')->middleware('verified')->name('home');


//Navigation
Route::post('/changeSession','NavigationController@changeSession')->name('changeSession');


//Masters
Route::resource('masters/titles', 'TitleController')->middleware('verified');
Route::resource('masters/genders', 'GenderController')->middleware('verified');
Route::resource('masters/nationalities', 'NationalityController')->middleware('verified');
Route::resource('masters/countries', 'CountryController')->middleware('verified');
Route::resource('masters/bloodgroups', 'BloodgroupController')->middleware('verified');
Route::resource('masters/documentCodes', 'DocumentCodeController')->middleware('verified');
Route::resource('masters/hospitals', 'HospitalController')->middleware('verified');
Route::resource('masters/branches', 'BranchController')->middleware('verified');

Route::resource('patients', 'PatientController')->middleware('verified');


Route::resource('physicians', 'PhysicianController')->middleware('verified');
Route::post('/physicians/getPhysicianDepartments','PhysicianController@getPhysicianDepartments')->name('physicians.getPhysicianDepartments');
Route::post('/physicians/destroyPhysicianDepartments','PhysicianController@destroyPhysicianDepartments')->name('physicians.destroyPhysicianDepartments');
Route::post('/physicians/storePhysicianDepartments','PhysicianController@storePhysicianDepartments')->name('physicians.storePhysicianDepartments');
Route::post('/physicians/getPhysicianSpecializations','PhysicianController@getPhysicianSpecializations')->name('physicians.getPhysicianSpecializations');
Route::post('/physicians/destroyPhysicianSpecializations','PhysicianController@destroyPhysicianSpecializations')->name('physicians.destroyPhysicianSpecializations');
Route::post('/physicians/storePhysicianSpecializations','PhysicianController@storePhysicianSpecializations')->name('physicians.storePhysicianSpecializations');


Route::resource('nurses', 'NurseController')->middleware('verified');
Route::post('/nurses/getNurseDepartments','NurseController@getNurseDepartments')->name('nurses.getNurseDepartments');
Route::post('/nurses/destroyNurseDepartments','NurseController@destroyNurseDepartments')->name('nurses.destroyNurseDepartments');
Route::post('/nurses/storeNurseDepartments','NurseController@storeNurseDepartments')->name('nurses.storeNurseDepartments');



Auth::routes(['verify' => true]);

Route::resource('specializations', 'SpecializationController');

Route::resource('departments', 'DepartmentController');

Route::resource('diseases', 'DiseaseController');

Route::resource('treatments', 'TreatmentController');

Route::resource('currencies', 'CurrencyController');



Route::resource('designations', 'DesignationController');

Route::resource('rooms', 'RoomController');

Route::resource('departmentRooms', 'DepartmentRoomController');
Route::post('/departmentRooms/getDepartmentRooms','DepartmentRoomController@getDepartmentRooms')->name('departmentRooms.getDepartmentRooms');
Route::post('/departmentRooms/destroyDepartmentRooms','DepartmentRoomController@destroyDepartmentRooms')->name('departmentRooms.destroyDepartmentRooms');
Route::post('/departmentRooms/storeDepartmentRooms','DepartmentRoomController@storeDepartmentRooms')->name('departmentRooms.storeDepartmentRooms');


Route::resource('sessions', 'SessionController');
Route::post('/sessions/getSessionDates','SessionController@getSessionDates')->name('sessions.getSessionDates');
Route::post('/sessions/getSessionDetails','SessionController@getSessionDetails')->name('sessions.getSessionDetails');

Route::resource('appointments', 'AppointmentController');
Route::post('/appointments/getAppointmentDetails','AppointmentController@getAppointmentDetails')->name('appointments.getAppointmentDetails');