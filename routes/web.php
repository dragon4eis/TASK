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
    return redirect('/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::apiResource('todoList' , \App\Http\Controllers\API\TodoListController::class);

    Route::post('disabledTask', [\App\Http\Controllers\API\DisabledTaskController::class, 'store'])->name('task.disable');
    Route::delete('disabledTask/{id}', [\App\Http\Controllers\API\DisabledTaskController::class, 'destroy'])->name('task.enable');

    Route::post('readyTask', [\App\Http\Controllers\API\ReadyTaskController::class, 'store'])->name('task.ready');
    Route::delete('readyTask/{id}', [\App\Http\Controllers\API\ReadyTaskController::class, 'destroy'])->name('task.open');
});

