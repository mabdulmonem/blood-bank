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
     dd($request->user());
});

Route::namespace("Api")->group(function (){
    Route::post("register","AuthController@register");
    Route::post("login","AuthController@login");
    Route::post("rest-password","AuthController@rest_password");
    Route::post("new-password","AuthController@new_password");
    Route::post("verify-account","AuthController@verify_account");


    //Main Controller Routes

    Route::get("governorates","MainController@governorates");
    Route::get("cities","MainController@cities");
    Route::get("blood-types","MainController@blood_types");



    Route::group(['middleware' => 'client:api'],function (){
        //Auth Controller
        Route::get("profile","AuthController@profile");
        Route::post("edit-profile","AuthController@edit_profile");
        Route::post("new-token",'AuthController@new_token');
        Route::get("notifications","AuthController@notifications");
        Route::get("notification-settings","MainController@get_notification_settings");
        Route::post("update-notification-settings","MainController@update_notification_settings");
        Route::get("favourites","AuthController@favourites");
        Route::get("toggle-favourites","AuthController@toggle_favourites");

        //Main Controller
        Route::get("posts","MainController@posts");
        Route::get("donation-requests","MainController@donation_requests");
        Route::post("donation-request",'MainController@creat_donation_request');
        Route::post("contact","MainController@contact");
        Route::get("categories",'MainController@categories');
        Route::get("settings",'MainController@settings');

        Route::post('create-token',function (){

            return \App\Http\Models\Token::create(request()->all())
                ? json([request('token')],1,'Token created successfully')
                : json('', 0,'sorry! token dont created ');
        });
    });

});
