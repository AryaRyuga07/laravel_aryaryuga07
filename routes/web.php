<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\HomeController;

Route::get('login',[AuthController::class,'showLogin'])->name('login');
Route::post('login',[AuthController::class,'login'])->name('doLogin');
Route::get('register',[AuthController::class,'showRegister'])->name('register');
Route::post('register',[AuthController::class,'register'])->name('doRegister');
Route::post('logout',[AuthController::class,'logout'])->name('logout');

Route::middleware('auth')->group(function(){
    Route::resource('hospitals',HospitalController::class);
    Route::resource('patients',PatientController::class);
    Route::get('home', [HomeController::class, 'index'])->name('home')->middleware('auth');
});
