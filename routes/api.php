<?php

use App\OtpTransaction;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'API\Auth\AuthController@login');
    Route::post('signup', 'API\Auth\AuthController@signup');

    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'API\Auth\AuthController@logout');
        Route::get('user', 'API\Auth\AuthController@user');
    });
});

//doc 1
Route::post('/sub_unsub', 'API\EventController@store');
Route::post('/renewal_charges', 'API\EventController@store');


//doc2
Route::post('/notification', 'API\NotificationController@store');



//doc3
//Route::post('/charging_request', 'API\PushRequestController@store');
//Route::post('/charging_confirm', 'API\ChargingConfirmationController@store');
Route::post('/subscribe_request', 'API\PushRequestController@subscribe_request');
Route::post('/subscribe_confirm', 'API\ChargingConfirmationController@subscribe_confirm');
Route::get('/tlist', 'API\ChargingConfirmationController@index');

Route::middleware('auth:api')->post('/test', function (){
    $user = auth('api')->user();
//    $temp = OtpTransaction::where('user_id',$user->id)->latest()->first();
    return response()->json($user->mobile_number, 200);
});

Route::get('/uuid',function (){
    return Uuid::generate()->string;
});






Route::get('/test',function (){
    $client1 =  new Client();
$r = $client1->request('GET', 'http://uinames.com/api/');
$r = \GuzzleHttp\json_decode($r->getBody());
return $r->name;
});

Route::get('/check',function (){
    $check_user = auth('api')->user();
    if (!isset($check_user)){
        return response()->json(['status'=>'0', 'description'=> 'user is not subscribed.'], 200);
    }
    else
        return response()->json(['status'=>'1', 'description'=> 'user is subscribed.'], 200);
});
