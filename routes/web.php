<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeagueController;

Route::get('/', [LeagueController::class, 'index']);
