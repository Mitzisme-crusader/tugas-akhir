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

Route::get('/', 'App\Http\Controllers\user_controller@index');

Route::post('/proses_login', 'App\Http\Controllers\user_controller@proses_login');

Route::get('/list_user', 'App\Http\Controllers\user_controller@pergi_ke_list_user');

Route::group(['prefix' => 'user'], function () {
    Route::get('/my_blog', 'food_blogger_controller@get_blog');
});
