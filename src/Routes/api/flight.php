<?php

use Hanafalah\ModuleFunding\Controllers\API\Flight\FlightController;
use Illuminate\Support\Facades\Route;

Route::apiResource('flight', FlightController::class)
    ->parameters(['flight' => 'id']);