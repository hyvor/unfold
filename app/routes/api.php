<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('/unfold', [Controller::class, 'init']);
Route::get('/iframe', [Controller::class, 'iframe']);