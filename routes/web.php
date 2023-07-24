<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $data['users'] = auth()->user();
    return view('dashboard.dashboard', $data);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/maintenance-dc', [MaintenanceController::class, 'indexDc'])->middleware(['auth', 'verified'])->name('maintenance-dc');
Route::get('/maintenance-hpc', [MaintenanceController::class, 'indexHpc'])->middleware(['auth', 'verified'])->name('maintenance-hpc');
Route::get('/edit-maintenance-dc', [MaintenanceController::class, 'editDc'])->middleware(['auth', 'verified'])->name('maintenance-dc-edit');
Route::post('api/equipment-metadata', [MaintenanceController::class, 'fetchEquipmentMetadata']);
Route::post('api/valid-form', [MaintenanceController::class, 'validForm']);
Route::post('api/item-form', [MaintenanceController::class, 'fetchItem']);
Route::post('api/param-form', [MaintenanceController::class, 'fetchParam']);
Route::post('api/save-log-maintenance', [MaintenanceController::class, 'saveLog']);
Route::post('api/edit-log-maintenance', [MaintenanceController::class, 'editLog']);

Route::get('/report-dc', [ReportController::class, 'indexDc'])->middleware(['auth', 'verified'])->name('report-dc');
Route::get('/preview-report-dc', [ReportController::class, 'previewDc'])->middleware(['auth', 'verified'])->name('preview-dc');
Route::post('api/report-list', [ReportController::class, 'reportList']);

Route::get('/logbook', [LogbookController::class, 'index'])->middleware(['auth', 'verified'])->name('logbook');
Route::get('/preview-logbook', [LogbookController::class, 'preview'])->middleware(['auth', 'verified'])->name('preview-logbook');
Route::get('/add-logbook', [LogbookController::class, 'logbookForm'])->middleware(['auth', 'verified'])->name('add-logbook');
Route::post('api/add-logbook', [LogbookController::class, 'addLogbook']);
Route::post('api/logbook-list', [LogbookController::class, 'logbookList']);

Route::get('/users', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('users');
Route::get('/add-user', [UserController::class, 'userForm'])->middleware(['auth', 'verified'])->name('add-user');
Route::post('api/user-list', [UserController::class, 'userList']);
Route::post('api/add-user', [UserController::class, 'addUser']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
