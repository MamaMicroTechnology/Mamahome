<?php

use Illuminate\Http\Request;

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
Route::get('messages','TokenController@index');
Route::post('message','TokenController@store');
Route::get('privatemessage','TokenController@pms');
// invoices
Route::get('ManagementMessages','TokenController@ManagementMessages');
Route::post('ManagementMessage','TokenController@ManagementMessage');
// it
Route::get('itMessages','TokenController@itMessages');
Route::post('itMessage','TokenController@itMessage');
// tl
Route::get('tlMessages','TokenController@tlMessages');
Route::post('tlMessage','TokenController@tlMessage');