<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ReportController;
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
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/maintenance-dc', [MaintenanceController::class, 'index'])->middleware(['auth', 'verified'])->name('maintenance-dc');
Route::get('/maintenance-hpc', [MaintenanceController::class, 'index'])->middleware(['auth', 'verified'])->name('maintenance-hpc');
Route::get('/edit-maintenance-dc', [MaintenanceController::class, 'editDc'])->middleware(['auth', 'verified'])->name('maintenance-dc-edit');
Route::post('api/equipment-metadata', [MaintenanceController::class, 'fetchEquipmentMetadata']);
Route::post('api/item-form', [MaintenanceController::class, 'fetchItem']);
Route::post('api/param-form', [MaintenanceController::class, 'fetchParam']);
Route::post('api/save-log-maintenance', [MaintenanceController::class, 'saveLog']);

Route::get('/report-dc', [ReportController::class, 'index'])->middleware(['auth', 'verified'])->name('report-dc');
Route::post('api/report-list', [ReportController::class, 'reportList']);

Route::get('/logbook', function () {
    return view('logbook');
})->middleware(['auth', 'verified'])->name('logbook');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
