<?php

use Facade\FlareClient\View;
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

// Visitor Side

Route::get('/', function () {
    return view('visitor.content.main');
})->name('homepage');
Route::get('signin', function () {
    return view('visitor.content.signin');
})->name('signin');
Route::get('signup', function () {
    return view('visitor.content.signup');
})->name('signup');


// User Side

Route::get('profile', 'User\ProfileController@index')->name('profile');
Route::get('add-venue', 'User\VenueController@index')->name('add-venue');
Route::get('add-event', function () {
    if (Auth::check()){
    return view('users.content.add-event');
    }
    else{
        return redirect()->route('signin');
    }
})->name('add-event');
Route::get('pricing', function () {
    return view('users.content.pricing');
})->name('pricing');
Route::get('events', function () {
    if (Auth::check()) {
    return view('users.content.events');
    }
    else{
        return redirect()->route('signin');
    }
})->name('events');
Route::get('social-wall', function () {
    return view('users.content.social-wall');
})->name('social-wall');
Route::post('/user-update-password', 'User\ProfileController@update_password')->name('user.update.password');
Route::post('/user-update-profile', 'User\ProfileController@update_profile')->name('user.update.profile');


Route::get('/admin/login', function () {
    if (!Auth::check()) {
        return view('auth.login');
    }

    
})->name('admin.login');

Auth::routes(['verify'=>true,'reset' => false]);

//middleware(['auth'=>'role:superadministrator'])->
Route::middleware(['auth'=>'role:superadministrator'])->group(function(){
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');
    Route::get('/profile-setting', 'Admin\ProfileController@profileSetting')->name('profile.setting');
    Route::post('/update-password', 'Admin\ProfileController@update_password')->name('update.password');
    Route::post('/update-profile', 'Admin\ProfileController@update_profile')->name('update.profile');
    Route::get('users/list', 'Admin\DashboardController@getUsers')->name('users.get');
    Route::get('users/profileview/{id}', 'Admin\UserProfileViewController@index')->name('usersprofile.view');
    Route::get('users/useractivation/{id}/{status}', 'Admin\UserProfileViewController@isActive')->name('users.activation');
    Route::get('all-roles', 'Admin\RoleController@index')->name('all.roles');
    Route::get('add-roles', 'Admin\RoleController@roles')->name('add.roles');
    Route::post('insertroles', 'Admin\RoleController@addrole')->name('insert.roles');
    Route::get('get-roles', 'Admin\RoleController@all_roles')->name('get.roles');
    Route::get('delete-roles/{id}', 'Admin\RoleController@delete_role')->name('delete.roles');
    Route::get('edit-roles/{role}', 'Admin\RoleController@edit_role')->name('edit.roles');
    Route::post('update-roles', 'Admin\RoleController@updaterole')->name('update.roles');

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
    Route::get('list-shortcode', 'Admin\ShortCodeController@list_shortcode')->name('list.shortcode');
    
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
    Route::get('delete-content/{id}', 'Admin\ContentController@delete_content')->name('delete.content');
    Route::get('price-packages', 'Admin\PricePackageController@index')->name('price.package');
    Route::post('add-package', 'Admin\PricePackageController@add_Package')->name('add.package');
    Route::get('all-payment_plans', 'Admin\PricePackageController@all_payment_plans')->name('all.payment_plans');
    Route::get('list-packages', 'Admin\PricePackageController@list_payment_plans')->name('list.packages');
    Route::get('delete-packages/{id}', 'Admin\PricePackageController@delete_package')->name('delete.packages');
    Route::get('editpaymentplans/{id}', 'Admin\PricePackageController@edit_paymentplans')->name('edit.paymentplans');
    Route::post('update-paymentplans', 'Admin\PricePackageController@update_paymentplans')->name('update.paymentplans');

    Route::get('orders-list', 'Admin\OrderDetailsController@index')->name('orders.list');
    Route::get('get.orders', 'Admin\OrderDetailsController@get_orders')->name('get.orders');
    Route::get('order/profileview/{id}', 'Admin\OrderDetailsController@profile_view')->name('orderusersprofile.view');
    Route::get('delete-order/{id}', 'Admin\OrderDetailsController@delete_order')->name('order.delete');
    
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
Route::get('get-post', 'TestingApi\FetchFacebookPostController@getPost')->name('get.post');

Route::get('log-out/{id}', 'Auth\LogOutController@index')->name('log.out');