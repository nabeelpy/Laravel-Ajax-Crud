<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\StudentController;
use \App\Http\Controllers\RealStdController;
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
    return view('welcome');
});

Route::get('/std', [App\Http\Controllers\RealStdController::class, 'std'])->name('std');

Route::post('/student/send', [App\Http\Controllers\RealStdController::class, 'send'])->name('send');

Route::get('/student/destroy/{id}', [App\Http\Controllers\RealStdController::class, 'destroy'])->name('destroy');

Route::get('/student/edit/{id}', [App\Http\Controllers\RealStdController::class, 'edit'])->name('edit');

