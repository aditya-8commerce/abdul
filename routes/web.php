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
Route::get('/', 'IndexController@index');
Route::get('/pdf', 'IndexController@pdf');
Route::get('/excel', 'IndexController@excel');


Auth::routes();
Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile', 'HomeController@profile')->name('profile');
Route::post('/change-password', 'UserController@changePassword')->name('changePassword');
Route::resource('/user-akses', 'UserController');
Route::get('/user-akses/download-foto/{fileName}', 'UserController@downloadFoto')->name('downloadFoto');
Route::resource('/divisi', 'DivisiController');
Route::resource('/jabatan', 'JabatanController');

/**
 * form cuti
 */
Route::get('/list-form-tidak-masuk', 'TidakMasukController@index')->name('tidakMasukIndex');
Route::get('/form-tidak-masuk/create', 'TidakMasukController@create')->name('tidakMasukCreate');
Route::get('/form-tidak-masuk/{id}', 'TidakMasukController@show')->name('tidakMasukShow');
Route::get('/form-tidak-masuk/print/{id}', 'TidakMasukController@print')->name('tidakMasukPrint');
Route::get('/form-tidak-masuk/{id}/edit', 'TidakMasukController@edit')->name('tidakMasukEdit');
Route::post('/form-tidak-masuk', 'TidakMasukController@store')->name('tidakMasukPost');
Route::delete('/form-tidak-masuk/{id}', 'TidakMasukController@destroy')->name('tidakMasukDelete');
Route::match(['put', 'patch'],'/form-tidak-masuk/{id}', 'TidakMasukController@update')->name('tidakMasukUpdate');
Route::get('/persetujuan-form-tidak-masuk', 'ApprovalTidakMasukController@index')->name('ApprovalTidakMasukIndex');
Route::get('/persetujuan-form-tidak-masuk/{id}', 'ApprovalTidakMasukController@show')->name('ApprovalTidakMasukShow');
Route::match(['put', 'patch'],'/persetujuan-form-tidak-masuk/{id}', 'ApprovalTidakMasukController@update')->name('ApprovalTidakMasukUpdate');

/**
 * form lembur
 */
Route::get('/list-form-lembur', 'LemburController@index')->name('lemburIndex');
Route::get('/form-lembur/create', 'LemburController@create')->name('lemburCreate');
Route::get('/form-lembur/{id}', 'LemburController@show')->name('lemburShow');
Route::post('/form-lembur', 'LemburController@store')->name('lemburPost');
Route::get('/form-lembur/{id}/edit', 'LemburController@edit')->name('lemburEdit');
Route::match(['put', 'patch'],'/form-lembur/{id}', 'LemburController@update')->name('lemburUpdate');
Route::delete('/form-lembur/{id}', 'LemburController@destroy')->name('lemburDelete');
Route::get('/form-lembur/print/{id}', 'LemburController@print')->name('lemburPrint');
Route::get('/persetujuan-form-lembur', 'ApprovalLemburController@index')->name('ApprovalLemburIndex');
Route::get('/persetujuan-form-lembur/{id}', 'ApprovalLemburController@show')->name('ApprovalLemburShow');
Route::match(['put', 'patch'],'/persetujuan-form-lembur/{id}', 'ApprovalLemburController@update')->name('ApprovalLemburUpdate');

/**
 * pelanggan
 */
Route::resource('/pelanggan', 'CustomerController');

/**
 * produk
 */
Route::resource('/produk', 'ProdukController');


/**
 * permintaan barang
 */
Route::resource('/permintaan-barang', 'PermintaanBarangController');
Route::get('/grafik-permintaan-barang', 'PermintaanBarangController@grafikPermintaanBarang')->name('grafikPermintaanBarang');
Route::get('/delete-permintaan-barang-detail/{id}', 'PermintaanBarangDetailsController@deleteById');
Route::get('/persetujuan-permintaan-barang', 'ApprovalPermintaanBarangController@index')->name('ApprovalPermintaanBarangIndex');
Route::get('/persetujuan-permintaan-barang/{id}', 'ApprovalPermintaanBarangController@show')->name('ApprovalPermintaanBarangShow');
Route::match(['put', 'patch'],'/persetujuan-permintaan-barang/{id}', 'ApprovalPermintaanBarangController@update')->name('ApprovalPermintaanBarangUpdate');

/**
 * jadwal
 */

Route::resource('/jadwal', 'JadwalController');

/**
 * jadwal sementara
 */
Route::resource('/jadwal-sementara', 'JadwalSementaraController');
Route::post('/jadwal-sementara/update-status/{id}', 'JadwalSementaraController@updateStatus');
Route::post('/jadwal-sementara/update-status/batal/{id}', 'JadwalSementaraController@updateStatusBatal');


/**
 * jadwal reminder
 */
Route::resource('/jadwal-reminder', 'JadwalReminderController');

/**
 * jadwal teknisi
 */
Route::get('/jadwal-teknisi', 'JadwalTeknisiController@index');

/**
 * jadwal teknisi
 */
Route::get('/jadwal-proses', 'JadwalProsesController@index');
Route::get('/jadwal-proses/{id}', 'JadwalProsesController@show');

/**
 * laporan
 */
Route::get('/laporan-uv/{id}/create', 'LaporanController@createUV');
Route::get('/laporan-uv/{id}/detail', 'LaporanController@detailUV');
Route::get('/laporan-uv/{id}/{idUv}/destroy', 'LaporanController@destroyUV');
Route::get('/laporan-uv/{id}/update', 'LaporanController@editUV');
Route::post('/laporan-uv/{id}/store', 'LaporanController@storeUV');
Route::post('/laporan-uv/{id}/{idUv}/update', 'LaporanController@updateUV');

 
Route::get('/laporan-ozon/{id}/create', 'LaporanController@createOzon');
Route::post('/laporan-ozon/{id}/store', 'LaporanController@storeOzon');
Route::get('/laporan-ozon/{id}/update', 'LaporanController@editOzon');
Route::get('/laporan-ozon/{id}/{idUv}/destroy', 'LaporanController@destroyOzon');
Route::get('/laporan-ozon/{id}/detail', 'LaporanController@detailOzon');
Route::post('/laporan-ozon/{id}/{idUv}/update', 'LaporanController@updateOzon');
 
Route::get('/laporan-emergency/{id}/create', 'LaporanController@createEmergency');
Route::post('/laporan-emergency/{id}/store', 'LaporanController@storeEmergency');
Route::get('/laporan-emergency/{id}/update', 'LaporanController@editEmergency');
Route::get('/laporan-emergency/{id}/{idUv}/destroy', 'LaporanController@destroyEmergency');
Route::get('/laporan-emergency/{id}/detail', 'LaporanController@detailEmergency');
Route::post('/laporan-emergency/{id}/{idUv}/update', 'LaporanController@updateEmergency');
 
Route::get('/laporan-log/{id}/create', 'LaporanController@createLog');
Route::post('/laporan-log/{id}/store', 'LaporanController@storeLog');
Route::get('/laporan-log/{id}/update', 'LaporanController@editLog');
Route::get('/laporan-log/{id}/{idUv}/destroy', 'LaporanController@destroyLog');
Route::get('/laporan-log/{id}/detail', 'LaporanController@detailLog');
Route::post('/laporan-log/{id}/{idUv}/update', 'LaporanController@updateLog');