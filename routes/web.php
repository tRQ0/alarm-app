<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlarmController;
use App\Http\Controllers\ConfigurationController;

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
    return redirect('/alarms');
});
Route::prefix('/alarms')->group(function () {
    Route::get('/', [AlarmController::class, 'index'])->name('alarms.index');
    Route::put('/update', [AlarmController::class, 'update'])->name('alarms.update');
    Route::put('/configuration/update', [ConfigurationController::class, 'update'])->name('config.update');
});
// Route::resource('/alarms', AlarmController::class);