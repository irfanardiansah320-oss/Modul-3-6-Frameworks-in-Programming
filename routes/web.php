<?php

use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RegistrationController; 

Route::get('/', function () {
    return view('welcome');
});

Route::get('/trash/activities', [ActivityController::class, 'trash'])->name('activities.trash');
Route::patch('/trash/activities/{activity}/restore', [ActivityController::class, 'restore'])
    ->withTrashed()
    ->name('activities.restore');

Route::resource('activities', ActivityController::class);
Route::resource('categories', CategoryController::class)->only(['index', 'destroy']);
Route::patch('activities/{activity}/publish', [ActivityController::class, 'publish'])->name('activities.publish');
Route::patch('activities/{activity}/complete', [ActivityController::class, 'complete'])->name('activities.complete');
Route::post('activities/{activity}/register', [RegistrationController::class, 'store'])
    ->name('activities.register');