<?php

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

Route::get('/', 'HomeController@index');

Route::get('/about-us', 'HomeController@about');

Route::get('/article/{id}','HomeController@post');
Route::get('/articles','HomeController@posts');
Route::get('/categories','HomeController@categories');
Route::get('/category/{id}/{title}','HomeController@category');

Route::post('/save-post','HomeController@favourite');



Route::get('/donation-requests','HomeController@donations');
Route::get('/donation-request/{id}','HomeController@donation');
Route::post('/donations-requests/sort','HomeController@donations_sort');

Route::get('/contact-us','HomeController@contact_form');
Route::post('/contact-us','HomeController@contact');

Route::get('/lang/{lang}','AuthController@lang');
Route::get('login','AuthController@login_form');
Route::post('login','AuthController@login');
Route::get('/profile/{id}','AuthController@profile')->middleware('client:clients');
Route::post('/profile/save/{id}','AuthController@profile')->middleware('client:clients');
Route::post('/logout', 'AuthController@logout')->middleware('client:clients');

Route::get('register','AuthController@register_form');
Route::post('register','AuthController@register');

Route::get('password/rest','AuthController@rest_password_form');
Route::post('/password/rest','AuthController@rest_password');

Route::get('password/update','AuthController@password_update_form');
Route::post('password/update','AuthController@password_update');

Route::get('/profile/verify/{rest_code}','AuthController@verify');


Route::middleware(["client:client","auth"])->group(function (){
    Route::get('/donation-requests/create','HomeController@donation_requests_create_form');
    Route::post('/donation-requests/create','HomeController@donation_requests_create_save');

});



/**
 * Admin Routes
 */
Route::group(['namespace'=>'Admin', 'middleware'=> 'auth','prefix'=>'ma-admin'],function (){

    Route::resource('/','HomeController');
    Route::resource('posts','PostsController');
    Route::resource('categories','CategoriesController');
    Route::get('user/edit','UsersController@user_edit_form');
    Route::post('user/edit','UsersController@user_edit');

    Route::group(['middleware' => ['role:admins']],function (){
        // Settings
        Route::get('settings','SettingsController@index')->middleware('role:admins');
        Route::post('settings','SettingsController@save')->middleware('role:admins');
        Route::get('setting/social-media','SettingsController@social_media')->middleware('role:admins');
        Route::post('setting/social-media','SettingsController@save_social_media')->middleware('role:admins');
        // Clients
        Route::resource('clients','ClientsController');
        Route::post('client/status','ClientsController@status');
        //Permissions
        Route::resource('permissions','PermissionsController');
        Route::get('permission/{id}/edit','PermissionsController@permission_form');
        Route::post('permission/{id}/edit','PermissionsController@permission');
        Route::post('role/permissions','UsersController@permission');
        // Users
        Route::resource('users','UsersController');
        Route::get('users-verify','UsersController@users_verify');
        // Governorates
        Route::resource('governorates','GovernoratesController');
        Route::resource('cities','CitiesController');
        Route::get('governorate/cities','CitiesController@cities');
        Route::resource('blood-types','BloodTypesController');
        // Reports
        Route::resource('reports','ReportsController');
        Route::get('replay/report/{id}','ReportsController@replay');
        Route::post('replay/report/{id}','ReportsController@replay_save');
        // Mails
        Route::resource('contact-messages','ContactsController');
        Route::get('replay/mail/{id}','ContactsController@replay');
        Route::post('replay/mail','ContactsController@replay_save');
        Route::resource('donation-requests','DonationRequestsController');

    });
});
/**
 * Admins Auth Routes
 */
Route::group(['prefix'=>'ma-admin'], function () {
    Auth::routes();
});
