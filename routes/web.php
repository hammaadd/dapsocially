<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/admin/login', function () {
    if (!Auth::check()) {
        return view('auth.login');
    }

    
})->name('admin.login');

Auth::routes(['verify'=>true,'register'=>false]);

//middleware(['auth'=>'role:superadministrator'])->
Route::middleware(['auth'=>'role:superadministrator'])->group(function(){
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');
    Route::get('/profile-setting', 'Admin\ProfileController@profileSetting')->name('profile.setting');
    Route::post('/update-password', 'Admin\ProfileController@update_password')->name('update.password');
    Route::post('/update-profile', 'Admin\ProfileController@update_profile')->name('update.profile');
    Route::get('users/list', 'Admin\DashboardController@getUsers')->name('users.get');
    Route::get('users/profileview/{id}', 'Admin\UserProfileViewController@index')->name('usersprofile.view');
    Route::get('users/useractivation/{id}/{status}', 'Admin\UserProfileViewController@isActive')->name('users.activation');
    Route::get('add-roles', 'Admin\RoleController@index')->name('add.roles');
    Route::post('insertroles', 'Admin\RoleController@addrole')->name('insert.roles');
    
    Route::get('getuserroles', 'Admin\RoleController@getuserrole')->name('getuser.role');
    Route::get('assignrole/{id}', 'Admin\RoleController@assignrole')->name('assign.role');
    Route::post('giveuserrole', 'Admin\RoleController@giveroletouser')->name('giveuser.roles');
    
    Route::get('userpermissions/list', 'Admin\RoleController@userpermission_list')->name('userpermission.list');
    Route::get('assignpermission/form/{id}', 'Admin\RoleController@permission_form')->name('assignpermission.form');
    Route::post('assignpermission', 'Admin\RoleController@assign_permission')->name('assign.permission');
    
    Route::get('/short-code', 'Admin\ShortCodeController@shortcode')->name('short.code');
    Route::post('/add-code', 'Admin\ShortCodeController@addcode')->name('add.code');
    Route::get('/edit-code/{shortQ}', 'Admin\ShortCodeController@editcode')->name('edit.code');
    Route::post('update-code', 'Admin\ShortCodeController@updatecode')->name('update.code');
    Route::get('/delete-code/{id}', 'Admin\ShortCodeController@deletecode')->name('delete.code');
    Route::get('get-shortcode', 'Admin\ShortCodeController@get_shortcode')->name('get.shortcode');
    
    Route::get('contactus-form', 'Admin\ContactUsController@index')->name('contact.us');
    Route::post('submitform', 'Admin\ContactUsController@add_Message')->name('add.message');
    Route::get('contactus', 'Admin\ContactUsController@get_contactus_list')->name('contactus.get');
    Route::get('contactus-list', 'Admin\ContactUsController@show_Contactus_list')->name('contactus.list');
    
    Route::get('content-form', 'Admin\ContentController@index')->name('content.form');
    Route::post('addcontent', 'Admin\ContentController@add_content')->name('add.content');
    Route::get('getcontents', 'Admin\ContentController@get_contents')->name('get.contents');
    Route::get('show-content', 'Admin\ContentController@show_content')->name('show.content');
    Route::get('editcontent/{id}', 'Admin\ContentController@content_edit')->name('edit.content');
    Route::post('updatecontent', 'Admin\ContentController@update_content')->name('update.content');
    Route::get('price-packages', 'Admin\PricePackageController@index')->name('price.package');
    Route::post('add-package', 'Admin\PricePackageController@add_Package')->name('add.package');
    
    Route::get('orders-list', 'Admin\OrderDetailsController@index')->name('orders.list');
    Route::get('get.orders', 'Admin\OrderDetailsController@get_orders')->name('get.orders');
    Route::get('order/profileview/{id}', 'Admin\OrderDetailsController@profile_view')->name('orderusersprofile.view');
    
    Route::get('notification-read/{id}', 'Admin\OrdersNotificationsController@index')->name('notification.read');
});


//Social Login routes
Route::get('login/google', 'Auth\LoginController@redirectToGoogle')->name('login.google');
Route::get('login/google/callback', 'Auth\LoginController@handleGoogleCallback');

Route::get('login/facebook', 'Auth\LoginController@redirectToFacebook')->name('login.facebook');
Route::get('login/facebook/callback', 'Auth\LoginController@handleFacebookCallback');



//User
Route::middleware(['auth'=>'role:user'])->get('user/home', 'User\HomeController@index')->name('user.home');
Route::get('user/venue', 'User\VenueController@index')->name('user.venue');
Route::post('add-venue', 'User\VenueController@add_venue')->name('add.venue');
Route::get('user/event', 'User\EventController@index')->name('user.event');
Route::post('add-event', 'User\EventController@add_event')->name('add.event');
Route::get('payment-details', 'User\OrderController@index')->name('payment.details');
Route::get('order.details/{amount}', 'User\OrderController@order_details')->name('order.details');
Route::post('place-order', 'User\OrderController@place_order')->name('place.order');
Route::get('check-out/{id}/{total_payment}', 'User\OrderController@check_out')->name('check.out');
Route::get('payment-processing/{id}/{total_payment}', 'User\OrderController@payment_process')->name('payment.processing');

Route::get('get-post', 'TestingApi\FetchFacebookPostController@getPost')->name('get.post');


//Square Api Route SquareApiController
Route::get('spayment', 'TestingApi\SquareApiController@index')->name('square.payment');
Route::post('payment-process', 'TestingApi\SquareApiController@payment_process')->name('payment.process');
