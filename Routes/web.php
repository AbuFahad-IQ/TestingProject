<?php

use App\Controllers\Home\HomeController;
use Src\Http\Route\Route;

Route::get('/', [HomeController::class, 'index'], 'home');
