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

    //Data Student
    Route::get('/student', \App\Http\Livewire\StudentData::class)->name('student');
    Route::get('/student/create', [App\Http\Controllers\Admin\StudentController::class, 'create'])->name('student.create');
    Route::post('/student/store', [App\Http\Controllers\Admin\StudentController::class, 'store'])->name('student.store');
    Route::get('/student/{id}/edit', [App\Http\Controllers\Admin\StudentController::class, 'edit'])->name('student.edit');
    Route::put('/student/{id}/update', [App\Http\Controllers\Admin\StudentController::class, 'update'])->name('student.update');

    //Profil Psikolog Siswa
    Route::get('/psikolog/{id}', \App\Http\Livewire\PsikologData::class)->name('psikolog.data');

    //Data Psikolog Upload
    Route::get('/psikolog', \App\Http\Livewire\PsychologistData::class)->name('psikolog');
    
    //Tahsin & Tahfizh Siswa
    Route::get('/tahsin/{id}', \App\Http\Livewire\TahsinData::class)->name('tahsin');
    Route::post('/surat', [App\Http\Controllers\Admin\SuratController::class, 'surat'])->name('surat');
    
    //Data Tahsin Upload
    Route::get('/tahsinUpload', \App\Http\Livewire\TahsinUpload::class)->name('tahsinUpload');

    //Portofolio
    Route::get('/portofolio', \App\Http\Livewire\Portofolio::class)->name('portofolio');

    //Export
    Route::get('/studentExport', [App\Http\Controllers\Admin\ExportController::class, 'studentExport'])->name('studentExport');
    Route::get('/psikologExport', [App\Http\Controllers\Admin\ExportController::class, 'psikologExport'])->name('psikologExport');
    Route::get('/tahsinExport', [App\Http\Controllers\Admin\ExportController::class, 'tahsinExport'])->name('tahsinExport');

    //Import
    Route::post('studentsImport', [App\Http\Controllers\Admin\ImportController::class, 'studentsImport'])->name('studentsImport');
    Route::post('psikologImport', [App\Http\Controllers\Admin\ImportController::class, 'psikologImport'])->name('psikologImport');
    Route::post('tahsinImport', [App\Http\Controllers\Admin\ImportController::class, 'tahsinImport'])->name('tahsinImport');
    

    //Role
    Route::get('/roles', \App\Http\Livewire\Master\DataRoles::class)->name('roles');
    Route::get('/roles/create', [App\Http\Controllers\Admin\Master\RoleController::class, 'create'])->name('role.create');
    Route::post('/roles/store', [App\Http\Controllers\Admin\Master\RoleController::class, 'store'])->name('role.store');
    Route::get('/roles/{id}', [App\Http\Controllers\Admin\Master\RoleController::class, 'edit'])->name('role.edit');
    Route::put('/roles/{id}', [App\Http\Controllers\Admin\Master\RoleController::class, 'update'])->name('role.update');

    Route::get('/permissions', \App\Http\Livewire\Master\DataPermissions::class)->name('permissions');
    Route::get('/users', \App\Http\Livewire\Master\DataUsers::class)->name('users');
    Route::get('/menus', \App\Http\Livewire\Master\DataMenus::class)->name('menus');
    Route::get('/kelas', \App\Http\Livewire\Master\KelasData::class)->name('kelas');
});