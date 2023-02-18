<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostApiController;
use App\Http\Controllers\CommunityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('communities', CommunityController::class);
    Route::apiResource('posts', PostApiController::class);
    Route::apiResource('comments', CommentController::class);
});
