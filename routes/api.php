<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductController;
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


//*     GET ROUTEs
Route::get('products', [ProductController::class, 'all']);
Route::get('categories', [CategoryController::class, 'all']);

//*     POST ROUTEs
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

//*     MIDDLEWAREs
Route::middleware('auth:sanctum')->get('user', [UserController::class, 'auth']);
