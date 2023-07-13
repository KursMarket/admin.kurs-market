<?php

use App\Http\Controllers\Api\Schools\SchoolsApiController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiBaseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/remove-media-by-collection', [ApiBaseController::class, 'removeMedia']);
Route::get('/school/{id}/image', [SchoolsApiController::class, 'getImage']);
Route::post('/banner/image', [SettingsController::class, 'getBannerImage']);
