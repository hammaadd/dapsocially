<?php

use App\Models\Role;
use Facade\FlareClient\View;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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

Route::get('/', 'Visitor\HomeController@index')->name('homepage');
Route::post('search', 'Visitor\HomeController@search')->name('search');
Route::get('about-us', 'Visitor\HomeController@about_us')->name('about.us');
Route::get('pricing', 'Visitor\HomeController@pricing')->name('pricing');

Route::get('gen',function(Request $req){
    echo public_path("admin/assets/adds");
});

Route::get('signin', function () {
    return view('visitor.content.signin');
})->name('signin');
Route::get('sign-up', function () {
    return view('visitor.content.signup');
})->name('signup');

//Public views
Route::get('events','User\EventController@events' )->name('events');
Route::get('more_venues','User\VenueController@load_more_venues' )->name('load.venues');
Route::get('venues', 'User\VenueController@venue')->name('venue');
Route::get('more_events','User\EventController@load_more_events' )->name('load.events');
// User Side
Route::get('socialwall/event/{event}', 'User\EventController@show_posts')->name('socialwall.event');

Route::middleware(['auth'=>'role:user'])->group(function(){
Route::get('profile', 'User\ProfileController@index')->name('profile');
Route::get('my-account', 'User\AccountController@index')->name('my.account');
Route::get('add-venue', 'User\VenueController@index')->name('add-venue');


Route::get('add-event','User\EventController@index' )->name('add-event');


Route::get('load-my-events','User\EventController@load_my_events' )->name('load.my.events');
Route::get('delete_my-event/{event}','User\EventController@delete_myevent' )->name('delete.my.event');


Route::post('search-event','User\EventController@search_Event' )->name('search.event');
Route::post('search-my-event','User\EventController@search_my_Event' )->name('search.my.event');
Route::post('search-my-venue','User\VenueController@search_my_Venue' )->name('search.my.venue');

Route::post('search-venue','User\VenueController@search_Venue' )->name('search.venue');
Route::get('load-my-venues','User\VenueController@load_my_venues' )->name('load.my.venues');
Route::get('delete_my-venue/{venue}','User\VenueController@delete_myvenue' )->name('delete.my.venue');
Route::get('my-event','User\EventController@my_events' )->name('my.events');
Route::get('my-venue','User\VenueController@my_venues' )->name('my.venues');
Route::get('edit-venue/{venue}','User\VenueController@edit_vanue' )->name('edit.venue');
Route::post('update-venue/{venue}','User\VenueController@update_venue' )->name('update.venue');

Route::get('edit-event/{event}','User\EventController@edit_event' )->name('edit.event');
Route::post('update-event/{event}','User\EventController@update_event' )->name('update.event');

Route::get('attach/facebook', 'User\AccountController@redirectToFacebook')->name('attach.facebook');



Route::get('facebook/posts/venue/{venue}', 'User\VenueController@show_posts')->name('facebook.posts.venue');

Route::get('migrate-tables', function(){
    Artisan::call('migrate');
});
// Route::get('attach/facebook/callback', 'User\AccountController@handleFacebookCallback');

// Route::get('pricing', function () {
//     return view('users.content.pricing');
// })->name('pricing');

Route::get('social-wall', function () {
    return view('users.content.social-wall');
})->name('social-wall');
Route::get('social-new', function () {
    return view('users.content.social-new');
})->name('social-new');
Route::post('/user-update-password', 'User\ProfileController@update_password')->name('user.update.password');
Route::post('/user-update-profile', 'User\ProfileController@update_profile')->name('user.update.profile');

Route::get('/attach-social-account', 'User\AccountController@attach_account')->name('attach.social.account');
Route::get('/filter_location', 'User\VenueController@filter_location')->name('filter.location');


});

Route::get('/admin/login', function () {
    if (!Auth::check()) {
        return view('auth.login');
    }else{
    Session::flash('message', "Logout the user id to login as admin");
        return back();
    }


})->name('admin.login');

Auth::routes(['verify'=>true,'login'=>true,]);

//middleware(['auth'=>'role:superadministrator'])->
Route::prefix('adm')->middleware(['auth'=>'role:superadministrator'])->group(function(){
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
    Route::get('role-permission/{id}', 'Admin\RoleController@view_role_permissions')->name('role.permission');

    Route::get('getuserroles', 'Admin\RoleController@getuserrole')->name('getuser.role');
    Route::get('assignrole/{id}', 'Admin\RoleController@assignrole')->name('assign.role');
    Route::post('giveuserrole', 'Admin\RoleController@giveroletouser')->name('giveuser.roles');

    Route::get('userpermissions/list', 'Admin\RoleController@userpermission_list')->name('userpermission.list');
    Route::get('assignpermission-form', 'Admin\RoleController@permission_form')->name('assignpermission.form');
    Route::post('assignpermission', 'Admin\RoleController@assign_permission')->name('assign.permission');
    Route::post('deassignpermission', 'Admin\RoleController@deassign_permission')->name('deassign.permission');

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
    Route::get('delete-messages/{id}', 'Admin\ContactUsController@delete_messages')->name('delete.messages');

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

    Route::get('messages', 'Admin\MessageController@index')->name('messages');
    Route::post('add-message', 'Admin\MessageController@add_message')->name('add.message');

    Route::get('all-messages', 'Admin\MessageController@all_messages')->name('all.messages');
    Route::get('get-messages', 'Admin\MessageController@get_messages')->name('get.messages');
    Route::get('edit-messages/{message}', 'Admin\MessageController@editmessage')->name('edit.messages');
    Route::post('update-messages', 'Admin\MessageController@updatemessage')->name('update.messages');
    Route::get('delete-messages/{id}', 'Admin\MessageController@deletemessage')->name('delete.messages');

    Route::get('send-notifications', 'Admin\NotificationsController@index')->name('send-notifications');
    Route::post('send-notifications-freeuser', 'Admin\NotificationsController@send_notification_to_freeuser')->name('send.notifications.freeuse');

    Route::get('image-adds', 'Admin\AddsController@index')->name('image.adds');
    Route::post('add-image-uploads', 'Admin\AddsController@upload_image_add')->name('add.image.uploads');
    Route::get('video-adds', 'Admin\AddsController@vidoe_add')->name('video.adds');
    Route::post('add-video-uploads', 'Admin\AddsController@upload_video_add')->name('add.video.uploads');

    Route::get('list-adds', 'Admin\AddsController@show_adds')->name('show.adds');
    Route::get('get-adds', 'Admin\AddsController@get_adds')->name('get.adds');

    Route::get('edit-adds/{add}', 'Admin\AddsController@edit_adds')->name('edit.adds');
    Route::get('delete-adds/{id}', 'Admin\AddsController@delete_id')->name('delete.adds');
    Route::post('update-image-add', 'Admin\AddsController@update_image_add')->name('update.image.add');
    Route::post('update-video-add', 'Admin\AddsController@update_video_add')->name('update.video.add');

    Route::get('add-category', 'Admin\CategoryController@index')->name('add.category');
    Route::post('insert-category', 'Admin\CategoryController@add_category')->name('insert.category');

    Route::get('list-category', 'Admin\CategoryController@show_category')->name('list.category');
    Route::get('get-category', 'Admin\CategoryController@get_category')->name('get.category');
    Route::get('edit-category/{category}', 'Admin\CategoryController@edit_category')->name('edit.category');
    Route::post('update-category', 'Admin\CategoryController@update_category')->name('update.category');
    Route::get('delete-/{id}', 'Admin\CategoryController@delete_category')->name('delete.category');

    Route::get('layout-control', 'Admin\LayoutController@index')->name('layout.control');

    Route::get('ev/images','Admin\ContentController@addImages')->name('ev.image');




});


//Social Login routes
Route::get('login/google', 'Auth\LoginController@redirectToGoogle')->name('login.google');
Route::get('login/google/callback', 'Auth\LoginController@handleGoogleCallback');

Route::get('login/facebook', 'Auth\LoginController@redirectToFacebook')->name('login.facebook');
Route::get('login/facebook/callback', 'Auth\LoginController@handleFacebookCallback');
Route::get('tiktok/callback','User\AccountController@getTTtoken')->name('tiktok.callback');
Route::get('tiktok/videos','User\AccountController@getVideos')->name('tiktok.videos');

Route::get('get/facebook/token','User\AccountController@getFbToken')->name('get.token.facebook');



Route::get('get/twitter/token','User\AccountController@getTwitterToken')->name('get.token.twitter');
Route::get('attach/twitter/account','User\AccountController@attachTwitter')->name('attach.twitter');

Route::get('/search/tweet','User\AccountController@searchTweet')->name('search.tweet');


// //User
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

//Route::get('get-post', 'TestingApi\FetchFacebookPostController@getPost')->name('get.post');

//Square Api Route SquareApiController
Route::get('spayment', 'TestingApi\SquareApiController@index')->name('square.payment');
Route::get('insta-posts', 'TestingApi\FetchFacebookPostController@instagram_posts')->name('insta.posts');
Route::post('payment-process', 'TestingApi\SquareApiController@payment_process')->name('payment.process');
Route::get('get-post', 'TestingApi\FetchFacebookPostController@getPost')->name('get.post');


Route::get('log-out/{id}', 'Auth\LogOutController@index')->name('log.out');

Route::get('/admin', function (){
    return redirect()->route('admin.login');
});




