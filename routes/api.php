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
Route::get('login','TokenController@buyerLogin');
Route::get('login/{username}/{password}','TokenController@getLogin');
Route::get('logout','TokenController@logout');
Route::get('saveLocation/{userid}/{latitude}/{longitude}','TokenController@saveLocation');
//Route::post('getregister',['middleware'=>'auth:api','uses'=> 'TokenController@getregister']);
Route::post('getregister', 'TokenController@getregister');
//user register
Route::post('/register','mamaController@postRegistration');
//byer login
Route::post('/blogin','BuyerController@postBuyerLogin');
//login users
Route::get('/authlogin','HomeController@authlogin');
//add project
Route::post('/addProject','mamaController@addProject');
Route::post('/addProject','TokenController@addProject');
Route::post('/addenquiry','TokenController@enquiry');

Route::post('/addImage','TokenController@addImage');
Route::get('/getproject','TokenController@getprojects');
Route::get('/getSingleProject','TokenController@getProject');