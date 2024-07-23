<?php

use App\Http\Controllers\Api\GHLWebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// use DB;
use Illuminate\Support\Facades\DB;

use App\Models\Sms;

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

    // Route::post('/receive-data', 'DataController@receive');
    Route::Resource('verify', 'SMSController@verify');
});

Route::post('/public-api', function (Request $request) {
    $email = $request->input('email');
    // print_r($email);die();
    DB::table('sms')->where('email', $email)->update(['submition_status' => '2']);
    // return DB::table('sms')->where('email','muhammadshoaib1119@gmail.com')->first();
});

// Process GHL form data
Route::post('process-ghl', [GHLWebhookController::class, 'process'])->middleware('verifyGHLAPIAccess');
