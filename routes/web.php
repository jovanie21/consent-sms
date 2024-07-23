<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\employee\SMSController;
//use DB;
use Illuminate\Support\Facades\DB;
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

Route::get('test', function () {
	Artisan::call('config:cache');
});
Route::get('test11', function () {
	Artisan::call('cache:clear');
});

 Route::get('/', function () {
     return view('welcome');
 });
 // Route::post('verify', [SMSController::class, 'verify']);

Auth::routes();
Route::post('/contact',[App\Http\Controllers\HomeController::class, 'contact']);
Route::post('/contact',[App\Http\Controllers\HomeController::class, 'contact']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/privacypolicy', [App\Http\Controllers\HomeController::class, 'privacypolicy']);
Route::get('/checkformstatus/{token}/{number}', [App\Http\Controllers\HomeController::class, 'checkformstatus']);
Route::get('/getip/{number}/{ip}', [App\Http\Controllers\HomeController::class, 'getip']);

Route::group(
	['middleware' => ['role:superadmin', 'auth'], 'namespace' => 'App\Http\Controllers\superadmin', 'prefix' => 'superadmin'],
	function () {
		Route::get('/home', 'HomeController@index');
		Route::get('/superadminsms', 'HomeController@smscheck');
		Route::get('/changepdfactive/{id}','HomeController@changepdfactive');
		Route::get('/changetodeactive/{id}','HomeController@changetodeactive');
                Route::get('/companyconsentsms/{id}','HomeController@companyconsentsms');
		Route::post('/resendsmsadmin/{id}','HomeController@resendsmsadmin');

		//Company
		Route::Resource('company', 'CompanyController');
		
		//Employee
		Route::Resource('superemployee', 'EmployeeSuperController');
		Route::post('superemployee/deletsms/{id}', 'EmployeeSuperController@deletesms');

		//profile
		Route::get('profile', 'ProfileController@index');
		Route::post('profile/update', 'ProfileController@update');
		Route::post('profile/updatepassword', 'ProfileController@updatepassword');
	}
);


Route::group(
	['middleware' => ['role:company', 'auth'], 'namespace' => 'App\Http\Controllers\company', 'prefix' => 'company'],
	function () {
		Route::get('/home', 'HomeController@index');
		Route::get('/companysms', 'HomeController@smscommpanycheck');
		Route::post('resendsms/{id}', 'HomeController@resendsms');
		//Employees
		Route::Resource('employee', 'EmployeeController');

		//profile
		Route::get('profile', 'ProfileController@index');
		Route::post('profile/update', 'ProfileController@update');
		Route::post('profile/updatepassword', 'ProfileController@updatepassword');
	}
);


Route::group(
	['middleware' => ['role:employee', 'auth'], 'namespace' => 'App\Http\Controllers\employee', 'prefix' => 'employee'],
	function () {
		Route::get('/home', 'HomeController@index');

		//Employees
		Route::Resource('sms', 'SMSController');
		// Route::Resource('verify', 'SMSController@verify');

		Route::post('resend/{id}', 'SMSController@resend');

		//profile
		Route::get('profile', 'ProfileController@index');
		Route::post('profile/update', 'ProfileController@update');
		Route::post('profile/updatepassword', 'ProfileController@updatepassword');
	}




);


	Route::post('/update-email-status', function (Request $request) {
    $email = $request->input('email');
    // die('shoab');
    // Update the table in the consentsms database using the $email value
    DB::table('sms')->where('email', $email)->update(['flag' => '1']);
    // return response()->json(['success' => true]);
});
