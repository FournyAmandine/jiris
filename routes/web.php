<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\JiriController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('welcome');
});

/*Route::get('/jiris', [JiriController::class, 'index'])->name('jiris.index');
Route::post('/jiris', [JiriController::class, 'store']);
Route::get('/jiris/{jiri}', [JiriController::class, 'show']);*/
Route::resource('jiris', App\Http\Controllers\JiriController::class)->middleware('auth');

/*Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
Route::post('/contacts', [ContactController::class, 'store']);
Route::get('/contacts/{contact}', [ContactController::class, 'show']);*/
Route::resource('contacts', App\Http\Controllers\ContactController::class)->middleware('auth');

/*
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::post('/projects', [ProjectController::class, 'store']);
Route::get('/projects/{project}', [ProjectController::class, 'show']);*/
Route::resource('projects', App\Http\Controllers\ProjectController::class);
