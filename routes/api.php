<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminForgetPasswordController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\NewsLetterController;
use App\Http\Controllers\Admin\AdminOrderController;

use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ForgetPasswordController;
use App\Http\Controllers\User\UserContentController;
use App\Http\Controllers\User\OrderController;

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
    Route::post('verify-email', [LoginController::class, 'verifyEmail']);

    // Order Callback
    Route::get('order-callback', [OrderController::class, 'changeOrderStatus']);

    //PROTDECTED ROUTE
    Route::middleware(['auth:api', 'scopes:user'])->group(function (){
        Route::get('/profile', [UserController::class, 'index']);
        Route::get('/reffral', [UserController::class, 'genrateReaffral']);

        // Content
        Route::get('content', [UserContentController::class, 'index']);
        Route::post('request-content', [UserContentController::class, 'uploade']);

        // Order
        Route::post('place-order', [OrderController::class, 'placeOrder']);
    });
});

//ADMIN ROUTE
Route::prefix('admin')->group(function (){
    Route::post('login', [AdminLoginController::class, 'login']);
    Route::post('forget_password', [AdminForgetPasswordController::class, 'forgetPassword']);
    Route::get('reset_password', [AdminForgetPasswordController::class, 'resetPassword']);
    Route::post('update-new-password', [AdminForgetPasswordController::class, 'updateNewPassword']);
    //protected route
    Route::middleware(['auth:admin-api','scopes:admin'])->group(function () {
        //Users 
        Route::get('', [AdminController::class, 'index']);
        Route::get('users', [AdminController::class, 'getUsers']);
        Route::delete('users', [AdminController::class, 'deleteUsers']);

        Route::post('edit-profile', [AdminController::class, 'editProfile']);
        Route::post('change-password', [AdminController::class, 'changePassword']);

        // Sub Admins
        Route::post('sub-admin', [AdminController::class, 'addSubAdmin']);
        Route::post('edit-sub-admin', [AdminController::class, 'editSubAdmin']);
        Route::get('sub-admin', [AdminController::class, 'getSubAdmin']);
        Route::delete('sub-admin', [AdminController::class, 'deleteSubAdmin']);

        // Subscription
        Route::get('subscription', [SubscriptionController::class, 'index']);
        Route::post('add-subscription', [SubscriptionController::class, 'addSubscription']);
        Route::post('edit-subscription', [SubscriptionController::class, 'editSubscription']);
        Route::get('subscription/{id}', [SubscriptionController::class, 'subscriptionDetail']);
        // Teacher
        Route::get('teacher-request', [TeacherController::class, 'index']);
        Route::post('teacher-request-status', [TeacherController::class, 'changeStatus']);

        // Content
        Route::get('content', [ContentController::class, 'index']);
        Route::post('content', [ContentController::class, 'uploade']);
        Route::post('content-request', [ContentController::class, 'contentRequest']);

        // NewsLetter
        Route::get('news-letter', [NewsLetterController::class, 'index']);
        Route::get('news-letter-history', [NewsLetterController::class, 'newsletterHistory']);
        Route::post('news-letter', [NewsLetterController::class, 'sendNewsletterNotification']);

        // Orders
        Route::get('orders', [AdminOrderController::class, 'index']);
        Route::get('orders/{id}', [AdminOrderController::class, 'orderDetail']);
    });
});