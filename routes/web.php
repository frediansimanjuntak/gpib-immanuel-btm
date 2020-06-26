<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/user', 'UserController@index')->name('user')->middleware('user');
Route::put('/user/{user}/update', 'UserController@update')->name('user.update')->middleware('user');
Route::get('/user/{user}/profile', 'UserController@show')->name('user.profile')->middleware('user');
Route::get('/user/{user}/history', 'UserController@history')->name('user.history')->middleware('user');
Route::get('/user/{user}/create', 'UserController@create')->name('user.create')->middleware('user');
Route::post('/user/{user}/store', 'UserController@store')->name('user.store')->middleware('user');
Route::get('/user/{ref_user_id}/family/{user_id}/edit', 'UserController@edit_family')->name('user.edit.family')->middleware('user');
Route::put('/user/{ref_user_id}/family/{user_id}/update', 'UserController@update_family')->name('user.update.family')->middleware('user');
Route::delete('/user/{ref_user_id}/family/{user_id}/delete', 'UserController@destroy_family')->name('user.destroy.family')->middleware('user');

Route::resource('activity_registrations', 'ActivityRegistrationController');
Route::get('activity_registrations/activity/{id}/schedule', 'ActivityRegistrationController@getActivitySchedule');
Route::get('activity_registrations/ticket/{activity_id}/{activity_schedule_id}', 'ActivityRegistrationController@getTicketRegistration');
Route::get('activity_registrations/{id}/cancelled/{user_id}', 'ActivityRegistrationController@cancelled')->name('activity_registration.cancelled')->middleware('user');

Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    // Controllers Within The "App\Http\Controllers\Admin" Namespace
    Route::get('/home', 'AdminController@index')->name('home');
    Route::get('/ticket_registrations/{id}/export_excel', 'TicketRegistrationController@export_excel')->name('export.activity_registration');
    Route::resource('activities', 'ActivityController');
    Route::resource('activities.activity_schedules', 'ActivityScheduleController');
    Route::resource('activity_registrations', 'ActivityRegistrationController');
    Route::resource('ticket_registrations', 'TicketRegistrationController');
    Route::resource('users', 'UserController');

    Route::get('ticket_registrations/activity/{id}/schedule', 'TicketRegistrationController@getActivitySchedule');
});

