<?php

use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\Api\QuoteController;
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


Route::get('/hello', function () {
    $data = ["message" => "Hello World"];
    return response()->json($data);
});

//route middleware for authenticated user
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/quote', QuoteController::class);
    Route::post('/logout', [ApiAuthController::class, 'logout']);
});

Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);

Route::post('/file-upload', [FileUploadController::class, 'uploadFile']);
Route::put('/file-upload', [FileUploadController::class, 'uploadFile']);


// Route::group('/quote', function () {
//     Route::get('listQuote/', [QuoteController::class, 'index']);
//     Route::get('getQuote/{id}', [QuoteController::class, 'show']);
//     Route::put('updateQuote/{id}', [QuoteController::class, 'update']);
//     Route::delete('deleteQuote/{id}', [QuoteController::class, 'destroy']);
// });
