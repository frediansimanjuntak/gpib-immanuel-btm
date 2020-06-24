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

Route::resource('activity_registrations', 'ActivityRegistrationController');
Route::get('activity_registrations/activity/{id}/schedule', 'ActivityRegistrationController@getActivitySchedule');

Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    // Controllers Within The "App\Http\Controllers\Admin" Namespace
    Route::get('/home', 'AdminController@index')->name('home');
    Route::resource('activities', 'ActivityController');
    Route::resource('activities.activity_schedules', 'ActivityScheduleController');
    Route::resource('activity_registrations', 'ActivityRegistrationController');
});

