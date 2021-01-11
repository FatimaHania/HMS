<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

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
    return view('auth.login');
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
Route::post('/masters/countries/getTelephoneCode','CountryController@getTelephoneCode')->name('countries.getTelephoneCode');
Route::post('/masters/countries/getCountryCurrency','CountryController@getCountryCurrency')->name('countries.getCountryCurrency');
Route::post('/masters/countries/getCountryNationality','CountryController@getCountryNationality')->name('countries.getCountryNationality');

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

Route::resource('specializations', 'SpecializationController')->middleware('verified');

Route::resource('departments', 'DepartmentController')->middleware('verified');

Route::resource('diseases', 'DiseaseController')->middleware('verified');

Route::resource('currencies', 'CurrencyController')->middleware('verified');



Route::resource('designations', 'DesignationController')->middleware('verified');

Route::resource('rooms', 'RoomController')->middleware('verified');

Route::resource('departmentRooms', 'DepartmentRoomController')->middleware('verified');
Route::post('/departmentRooms/getDepartmentRooms','DepartmentRoomController@getDepartmentRooms')->name('departmentRooms.getDepartmentRooms');
Route::post('/departmentRooms/destroyDepartmentRooms','DepartmentRoomController@destroyDepartmentRooms')->name('departmentRooms.destroyDepartmentRooms');
Route::post('/departmentRooms/storeDepartmentRooms','DepartmentRoomController@storeDepartmentRooms')->name('departmentRooms.storeDepartmentRooms');


Route::resource('sessions', 'SessionController')->middleware('verified');
Route::post('/sessions/getSessionDates','SessionController@getSessionDates')->name('sessions.getSessionDates');
Route::post('/sessions/getSessionDetails','SessionController@getSessionDetails')->name('sessions.getSessionDetails');
Route::post('/sessions/cancelSession','SessionController@cancelSession')->name('sessions.cancelSession');
Route::post('/sessions/startSession','SessionController@startSession')->name('sessions.startSession');
Route::post('/sessions/completeSession','SessionController@completeSession')->name('sessions.completeSession');
/** Public Portal */
Route::post('/sessions/getSessionsPP','SessionController@getSessionsPP')->name('sessions.getSessionsPP'); 


Route::resource('appointments', 'AppointmentController')->middleware('verified');
Route::post('/appointments/getAppointmentDetails','AppointmentController@getAppointmentDetails')->name('appointments.getAppointmentDetails');
Route::post('/appointments/getCardDetails','AppointmentController@getCardDetails')->name('appointments.getCardDetails');
Route::post('/appointments/getBookingDetails','AppointmentController@getBookingDetails')->name('appointments.getBookingDetails');
Route::post('/appointments/bookAppointments','AppointmentController@bookAppointments')->name('appointments.bookAppointments');
Route::post('/appointments/cancelAppointments','AppointmentController@cancelAppointments')->name('appointments.cancelAppointments');
Route::post('/appointments/getCards','AppointmentController@getCards')->name('appointments.getCards');
Route::post('/appointments/updatePhysicianFilter','AppointmentController@updatePhysicianFilter')->name('appointments.updatePhysicianFilter');
Route::post('/appointments/updatePaymentStatus','AppointmentController@updatePaymentStatus')->name('appointments.updatePaymentStatus');
/** public portal */
Route::get('/appointments/physician/{id}','AppointmentController@getAppointmentsPP')->name('appointments.getAppointmentsPP');

Route::resource('treatments', 'TreatmentController')->middleware('verified');
/** Treatments */
Route::get('/treatments/create/PP/{id}','TreatmentController@createPP')->name('treatments.createPP');

Route::resource('patientFiles', 'PatientFileController')->middleware('verified');
Route::post('/patientFiles/getPatientFiles','PatientFileController@getPatientFiles')->name('patientFiles.getPatientFiles');

Route::resource('users', 'UserController')->middleware('verified');
Route::post('/users/getUserUsergroups','UserController@getUserUsergroups')->name('users.getUserUsergroups');
Route::post('/users/destroyUserUsergroups','UserController@destroyUserUsergroups')->name('users.destroyUserUsergroups');
Route::post('/users/storeUserUsergroups','UserController@storeUserUsergroups')->name('users.storeUserUsergroups');
Route::post('/users/updateUserProfile/{id}','UserController@updateUserProfile')->name('users.updateUserProfile');
Route::post('/users/linkHospital/{id}','UserController@linkHospital')->name('users.linkHospital');
Route::get('/users/verify/{id}','UserController@verifyHospitalLink')->name('users.verifyHospitalLink');

Route::resource('usergroups', 'UsergroupController')->middleware('verified');
Route::post('/usergroups/getUsergroupModules','UsergroupController@getUsergroupModules')->name('usergroups.getUsergroupModules');
Route::post('/usergroups/storeUsergroupModules','UsergroupController@storeUsergroupModules')->name('usergroups.storeUsergroupModules');

Route::resource('publicUsers', 'PublicUserController')->middleware('verified');
Route::post('/publicUsers/updateUsersFilter','PublicUserController@updateUsersFilter')->name('publicUsers.updateUsersFilter');
Route::post('/publicUsers/getLinkedUsers','PublicUserController@getLinkedUsers')->name('publicUsers.getLinkedUsers');
Route::post('/publicUsers/updateLinkApprovalStatus','PublicUserController@updateLinkApprovalStatus')->name('publicUsers.updateLinkApprovalStatus');

Auth::routes(['verify' => true]);





