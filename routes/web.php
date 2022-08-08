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

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function() {

    Route::group(['middleware' => ['role:admin']], function() {

        //Role
        Route::get('/roles', \App\Http\Livewire\Master\DataRoles::class)->name('roles');
        Route::get('/roles/create', [App\Http\Controllers\Admin\Master\RoleController::class, 'create'])->name('role.create');
        Route::post('/roles/store', [App\Http\Controllers\Admin\Master\RoleController::class, 'store'])->name('role.store');
        Route::get('/roles/{id}', [App\Http\Controllers\Admin\Master\RoleController::class, 'edit'])->name('role.edit');
        Route::put('/roles/{id}', [App\Http\Controllers\Admin\Master\RoleController::class, 'update'])->name('role.update');

        Route::get('/permissions', \App\Http\Livewire\Master\DataPermissions::class)->name('permissions');
        Route::get('/users', \App\Http\Livewire\Master\DataUsers::class)->name('users');
        Route::get('/menus', \App\Http\Livewire\Master\DataMenus::class)->name('menus');
        
    });

    Route::get('/profile', \App\Http\Livewire\ProfileData::class)->name('profile');
});