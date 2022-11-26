<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\WalletController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     // return $request->user();
//     Route::post('/user/profile/update/{user}', [ProfileController::class, 'profile']);
// });

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::post('admin/register', [AuthController::class, 'AdminRegister']);
Route::post('admin/login', [AuthController::class, 'AdminLogin']);

Route::group([
    'prefix' => 'user',
    'middleware' => ['auth:sanctum'],
], function() {
    Route::get('profile', [ProfileController::class, 'profile']);
    Route::post('profile/edit', [ProfileController::class, 'EditProfile']);
    Route::get('wallets', [WalletController::class, 'wallets']);
    Route::post('wallet/create', [WalletController::class, 'newWallet']);
});



Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth:sanctum'],
], function() {

    Route::get('/users', [ProfileController::class, 'getUsers']);
    Route::get('/user/profile/{user}', [ProfileController::class, 'getUserProfile']);
    Route::post('/user/profile/update/{user}', [ProfileController::class, 'updateUserProfile']);
    Route::post('/user/profile/delete/{user}', [ProfileController::class, 'destroyUser']);

});
