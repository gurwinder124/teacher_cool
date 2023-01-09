<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminForgetPasswordController;

use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ForgetPasswordController;

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

Route::get('login', [LoginController::class, 'login']);
// USER ROUTE
Route::prefix('v1')->group(function () {

    Route::post('login', [LoginController::class, 'login']);
    Route::post('register', [LoginController::class, 'register']);
    Route::post('forget_password', [ForgetPasswordController::class, 'forgetPassword']);
    Route::get('reset_password', [ForgetPasswordController::class, 'resetPassword']);
    Route::post('update-new-password', [ForgetPasswordController::class, 'updateNewPassword']);
    //PROTDECTED ROUTE
    Route::middleware(['auth:api', 'scopes:user'])->group(function (){
        Route::get('/profile', [UserController::class, 'index']);
    });
});

//ADMIN ROUTE
Route::prefix('admin')->group(function (){
    Route::post('login', [AdminLoginController::class, 'login']);
    Route::post('register', [AdminLoginController::class, 'register']);
    Route::post('forget_password', [AdminForgetPasswordController::class, 'forgetPassword']);
    Route::get('reset_password', [AdminForgetPasswordController::class, 'resetPassword']);
    Route::post('update-new-password', [AdminForgetPasswordController::class, 'updateNewPassword']);
    //protected route
    Route::middleware(['auth:admin-api','scopes:admin'])->group(function () {
        Route::get('users', [AdminController::class, 'index']);
        Route::get('sub-admin', [AdminController::class, 'addSubAdmin']);
   });
});