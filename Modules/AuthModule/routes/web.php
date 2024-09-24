<?php

use Illuminate\Support\Facades\Route;
use Modules\AuthModule\Http\Controllers\AdminPermissionController;
use Modules\AuthModule\Http\Controllers\AdminRoleController;
use Modules\AuthModule\Http\Controllers\AdminUserController;
use Modules\AuthModule\Http\Controllers\AuthModuleController;

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

Route::group([], function () {
    Route::resource('authmodule', AuthModuleController::class)->names('authmodule');
});
Route::get('/myadmin/login', [AuthModuleController::class, 'showLoginForm'])->name('admin.login');
Route::post('/myadmin/login', [AuthModuleController::class, 'login'])->name('adminlogin');
Route::post('/myadmin/logout', [AuthModuleController::class, 'logout'])->name('admin.logout');


Route::group(['prefix' => '/myadmin',  'middleware' => 'auth:admin'], function () {
    //users 
    Route::resource('/adminusers', AdminUserController::class)->names('adminusers');
    Route::get('/adminuser-ajax', [AdminUserController::class, 'indexAjax'])->name('adminusers.indexAjax');
    Route::post('/adminuser-bulk-delete', [AdminUserController::class, 'bulkDelete'])->name('adminusers.bulkDelete');
    Route::get('/search-adminusers', [AdminUserController::class, 'search'])->name('adminusers.search');

    // Roles 
    Route::resource('/adminroles', AdminRoleController::class)->names('adminroles');
    Route::get('/adminrole-ajax', [AdminRoleController::class, 'indexAjax'])->name('adminroles.indexAjax');
    Route::post('/adminrole-bulk-delete', [AdminRoleController::class, 'bulkDelete'])->name('adminroles.bulkDelete');
    Route::get('/search-adminroles', [AdminRoleController::class, 'search'])->name('adminroles.search');

    // Permissions
    Route::resource('/adminpermissions', AdminPermissionController::class)->names('adminpermissions');
    Route::get('/adminpermission-ajax', [AdminPermissionController::class, 'indexAjax'])->name('adminpermissions.indexAjax');
    Route::post('/adminpermission-bulk-delete', [AdminPermissionController::class, 'bulkDelete'])->name('adminpermissions.bulkDelete');
    Route::get('/search-adminpermissions', [AdminPermissionController::class, 'search'])->name('adminpermissions.search');
});
