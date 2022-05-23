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

Route::group(['prefix' => 'admin'], function () {
    //customer
    Route::get('/list_customer', 'App\Http\Controllers\admin_controller@pergi_ke_list_customer');

    Route::get('/add_customer', 'App\Http\Controllers\admin_controller@pergi_ke_add_customer');

    Route::post('/proses_add_customer', 'App\Http\Controllers\admin_controller@proses_add_customer');

    Route::post('/delete_customer', 'App\Http\Controllers\admin_controller@proses_delete_customer');

    //service
    Route::get('/list_service', 'App\Http\Controllers\admin_controller@pergi_ke_list_service');

    Route::get('/add_service', 'App\Http\Controllers\admin_controller@pergi_ke_add_service');

    Route::post('/proses_add_service', 'App\Http\Controllers\admin_controller@proses_add_service');

    Route::get('logout', 'App\Http\Controllers\admin_controller@proses_logout');

    //Dokumen
    //Dokumen SPK

    Route::get('/make_document_SPK', 'App\Http\Controllers\admin_controller@pergi_ke_make_document_SPK');

    Route::get('/list_SPK', 'App\Http\Controllers\admin_controller@pergi_ke_list_SPK');

    Route::get('/search_SPK', 'App\Http\Controllers\admin_controller@search_SPK');

    Route::post('/proses_save_document', 'App\Http\Controllers\admin_controller@proses_save_document_SPK');

    //Dokumen SO

    Route::get('/make_dokumen_SO', 'App\Http\Controllers\admin_controller@pergi_ke_make_dokumen_SO');

    Route::get('/list_SO', 'App\Http\Controllers\admin_controller@pergi_ke_list_dokumen_SO');

    Route::post('/proses_add_dokumen_so', 'App\Http\Controllers\admin_controller@proses_add_dokumen_so');

    Route::get('/get_data_customer', 'App\Http\Controllers\admin_controller@get_data_customer');

    Route::get('/edit_dokumen_so', 'App\Http\Controllers\admin_controller@pergi_ke_edit_so');

    Route::post('/proses_edit_dokumen_so', 'App\Http\Controllers\admin_controller@proses_edit_dokumen_so');

    //Dokumen Simpan Berjalan

    Route::get('/make_dokumen_simpan_berjalan', 'App\Http\Controllers\admin_controller@pergi_ke_make_dokumen_simpan_berjalan');

    Route::post('/proses_add_dokumen_simpan_berjalan', 'App\Http\Controllers\admin_controller@proses_add_dokumen_simpan_berjalan');

    Route::post('/proses_save_dokumen_simpan_berjalan', 'App\Http\Controllers\admin_controller@proses_update_dokumen_simpan_berjalan');

    Route::get('/list_dokumen_simpan_berjalan', 'App\Http\Controllers\admin_controller@pergi_ke_list_dokumen_simpan_berjalan');

    Route::get('/search_dokumen_simpan_berjalan', 'App\Http\Controllers\admin_controller@search_dokumen_simpan_berjalan');

    Route::get('/detail_dokumen_simpan_berjalan', 'App\Http\Controllers\admin_controller@pergi_ke_detail_dokumen_simpan_berjalan');

    //Tagihan
    //Vendor
    Route::get('/input_tagihan_vendor', 'App\Http\Controllers\admin_controller@pergi_ke_input_tagihan_vendor');

    Route::post('/proses_input_tagihan_vendor', 'App\Http\Controllers\admin_controller@proses_input_tagihan_vendor');

    Route::get('/detail_tagihan_vendor', 'App\Http\Controllers\admin_controller@pergi_ke_detail_tagihan_vendor');

    Route::get('/list_tagihan_vendor', 'App\Http\Controllers\admin_controller@pergi_ke_list_tagihan_vendor');

    //Customer
    Route::get('/input_tagihan_customer', 'App\Http\Controllers\admin_controller@pergi_ke_input_tagihan_customer');

    Route::post('/proses_input_tagihan_customer', 'App\Http\Controllers\admin_controller@proses_input_tagihan_customer');

    Route::get('/list_tagihan_customer', 'App\Http\Controllers\admin_controller@pergi_ke_list_tagihan_customer');

    Route::get('/get_data_extra_service_SO', 'App\Http\Controllers\admin_controller@get_data_extra_service_SO');


});

Route::group(['prefix' => 'user'], function () {
    Route::get('/my_blog', 'food_blogger_controller@get_blog');
});
