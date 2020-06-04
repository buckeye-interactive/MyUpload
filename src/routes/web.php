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

Route::get('/', 'HomeController@index')->name('welcome');
Route::resource('media-item', 'MediaItemController')->only(['create']);

Route::middleware(['prevent'])->group(function () {
    Route::get('/media-item/bulk', 'MediaItemController@bulk')->name('media-item.bulk');
    Route::put('/media-item/bulk', 'MediaItemController@bulkUpdate')->name('media-item.bulk.update');
    Route::resource('media-item', 'MediaItemController')->except([
        'index', 'create', 'destroy', 'show',
    ]);
    Route::redirect('/home', route('media-item.create'));
    Route::get('batch-submit', 'MediaItemController@batchSubmit')->name('batch-submit');
    Route::get('/completed', 'MediaItemController@completed')->name('completed');
    Route::get('/cancel', 'MediaItemController@cancel')->name('cancel');
});

Route::prefix('api')->name('api.')->group(function () {
    Route::post('session-store', 'HomeController@sessionStore')->name('session-store');
    Route::resource('media-item', 'Api\MediaItemController');
});

Route::middleware(['auth'])->group(function () {
    Route::get('account-settings', 'HomeController@accountSettings')->name('account-settings');
    Route::post('account-settings', 'HomeController@accountSettingsUpdate')->name('account-settings-update');

    Route::get('/media-item/approved', 'MediaItemController@approved')->name('approved');
    Route::get('/media-item/download-approved', 'MediaItemController@downloadApproved')->name('download-approved');
    Route::get('/media-item/rejected', 'MediaItemController@rejected')->name('rejected');
    Route::get('/media-tem/top-five', 'MediaItemController@topFive')->name('top-five');
    Route::put('/media-tem/top-five', 'MediaItemController@addTopFive')->name('add-top-five');
    Route::resource('media-item', 'MediaItemController')->only([
        'destroy', 'show',
    ]);

    Route::get('/admin', 'MediaItemController@adminDashboard')->name('admin');
    Route::put('/admin/admin-approve/{mediaItem}', 'MediaItemController@adminApprove')->name('admin-approve');
    Route::put('/admin/admin-reject/{mediaItem}', 'MediaItemController@adminReject')->name('admin-reject');
    Route::post('/admin/approve', 'MediaItemController@adminBulkApprove');
    Route::post('/admin/reject', 'MediaItemController@adminBulkReject');
    Route::get('/admin/export', 'MediaItemController@export')->name('admin-export');

    Route::resource('/admin/ban', 'BanController')->only(['index', 'store', 'destroy']);
    Route::resource('/admin/user', 'UserController')->only(['index', 'store', 'destroy']);
});

Auth::routes(['register' => false]);
