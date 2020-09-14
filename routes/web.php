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

Route::resource('nurses', 'NurseController')->middleware('verified');


Auth::routes(['verify' => true]);

Route::resource('specializations', 'SpecializationController');

Route::resource('departments', 'DepartmentController');

Route::resource('diseases', 'DiseaseController');

Route::resource('treatments', 'TreatmentController');

Route::resource('currencies', 'CurrencyController');