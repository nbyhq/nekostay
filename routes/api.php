<?php

use App\Http\Controllers\Api\AdoptionApiController;
use App\Http\Controllers\Api\CatApiController;
use Illuminate\Support\Facades\Route;

Route::apiResource('cats', CatApiController::class)->names('api.cats');
Route::apiResource('adoptions', AdoptionApiController::class)->names('api.adoptions');
