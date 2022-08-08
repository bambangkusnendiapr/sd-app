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

    Route::get('/profile', \App\Http\Livewire\ProfileData::class)->name('profile');

    Route::get('/student', \App\Http\Livewire\StudentData::class)->name('student');
    Route::get('/student/create', [App\Http\Controllers\Admin\StudentController::class, 'create'])->name('student.create');
    Route::post('/student/store', [App\Http\Controllers\Admin\StudentController::class, 'store'])->name('student.store');
    Route::get('/student/{id}/edit', [App\Http\Controllers\Admin\StudentController::class, 'edit'])->name('student.edit');
    Route::put('/student/{id}/update', [App\Http\Controllers\Admin\StudentController::class, 'update'])->name('student.update');

    //Export
    Route::get('/studentExport', [App\Http\Controllers\Admin\ExportController::class, 'studentExport'])->name('studentExport');

    //Import
    Route::post('studentsImport', [App\Http\Controllers\Admin\ImportController::class, 'studentsImport'])->name('studentsImport');

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
});