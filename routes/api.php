<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\main\userController;


Route::get("login", [userController::class, "login"])->name('login');
Route::post("loginCheck", [userController::class, "loginCheck"])->name('user.loginCheck');

