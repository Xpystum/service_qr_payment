<?php

use App\Http\Controllers\Api\Test\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TestController::class, 'index']);
