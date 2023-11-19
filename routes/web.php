<?php

use App\Http\Controllers\DataTable\DataTableController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Settings\LogController;
use App\Http\Controllers\Settings\PermissionController;
use App\Http\Controllers\Settings\RoleController;
use App\Http\Controllers\StaterkitController;
use App\Http\Controllers\UserController;
use Carbon\Carbon;
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

Route::get('/', [StaterkitController::class, 'home'])->name('home');
Route::get('home', [StaterkitController::class, 'home'])->name('home');
// Route Components
Route::get('layouts/collapsed-menu', [StaterkitController::class, 'collapsed_menu'])->name('collapsed-menu');
Route::get('layouts/full', [StaterkitController::class, 'layout_full'])->name('layout-full');
Route::get('layouts/without-menu', [StaterkitController::class, 'without_menu'])->name('without-menu');
Route::get('layouts/empty', [StaterkitController::class, 'layout_empty'])->name('layout-empty');
Route::get('layouts/blank', [StaterkitController::class, 'layout_blank'])->name('layout-blank');


//Users
Route::controller(UserController::class)->prefix('users')->name('users.')->group(function () {
    Route::get('settings', 'viewUserSettings')->name('settings');
    Route::get('/', 'index')->name('index')->middleware('permission:view users');
    Route::post('/', 'store')->name('store')->middleware('permission:create users');
    Route::delete('/{user}', 'delete')->name('delete')->middleware('permission:delete users');
});

//Settings
Route::controller(PermissionController::class)->prefix('permissions')->name('permissions.')->middleware("permission:edit permissions")->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/by-user', 'by_user')->name('by_user');
    Route::post('/by-user', 'store_by_user')->name('store.by_user');
    Route::post('', 'store')->name('store');
});

//Logs
Route::get('logs', [LogController::class, 'index'])->name('logs.index')->middleware('permission:view logs');

//Roles
Route::controller(RoleController::class)->prefix('roles')->name('roles.')->middleware("permission:crud roles")->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{role}', 'show')->name('show');
    Route::patch('/{role}', 'update')->name('update');
    Route::post('/', 'store')->name('store');
    Route::delete('/{role}', 'delete')->name('delete');
});

//Datatables
Route::controller(DataTableController::class)->prefix('datatable')->name('datatable.')->group(function () {
    Route::get('/roles', 'roles')->name('roles')->middleware('permission:crud roles');
    Route::get('/logs', 'logs')->name('logs')->middleware('permission:view logs');
    Route::get('/users', 'users')->name('users')->middleware('permission:view users');
});

//Imports
Route::controller(ImportController::class)->prefix('import')->name('import.')->group(function () {
    Route::post('/users', 'users')->name('users')->middleware('permission:create users');
});

// locale Route
Route::get('lang/{locale}', [LanguageController::class, 'swap']);
