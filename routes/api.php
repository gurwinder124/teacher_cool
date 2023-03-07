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
use App\Http\Controllers\Admin\SystemSettingController;
use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\AssignmentPaymentController;
use App\Http\Controllers\Admin\NotificationController;
//User Controllers
use App\Http\Controllers\User\DashboardContentController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ForgetPasswordController;
use App\Http\Controllers\User\UserContentController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\BillingInfoController;

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
/*
---------------------------------------------------------
    USER ROUTES
----------------------------------------------------------
*/
Route::prefix('v1')->group(function () {

    Route::post('login', [LoginController::class, 'login']);
    Route::post('register', [LoginController::class, 'register']);
    Route::post('forget-password', [ForgetPasswordController::class, 'forgetPassword']);
    Route::post('reset-password', [ForgetPasswordController::class, 'resetPassword']);
    Route::post('verify-reset-token', [ForgetPasswordController::class, 'verifyResetPassToken']);
    
    Route::post('verify-email', [LoginController::class, 'verifyEmail']);
    Route::get('register-info', [LoginController::class, 'registerInfo']);

    // Order Callback
    Route::get('order-callback', [OrderController::class, 'changeOrderStatus']);

    // content
    Route::get('dashboard-content', [DashboardContentController::class, 'index']);


    //PROTDECTED ROUTES FOR BOTH TEACHER AND STUDENT
    Route::middleware(['auth:api', 'scope:user,teacher'])->group(function (){
        Route::get('/profile', [UserController::class, 'index']);
        Route::post('edit-profile', [UserController::class, 'editProfile']);
        Route::get('/reffral', [UserController::class, 'genrateReaffral']);
        Route::post('/change-password', [UserController::class, 'changePassword']);

        // Notifications
        Route::get('/notification', [UserController::class, 'notification']);

    });

    //PROTDECTED ROUTES FOR TEACHER ONLY
    Route::middleware(['auth:api', 'scopes:teacher'])->group(function (){
        // Content
        Route::get('billing-info', [BillingInfoController::class, 'index']);
        Route::post('billing-info', [BillingInfoController::class, 'addBillingInfo']);
    });

    //PROTDECTED ROUTES FOR STUDENT ONLY
    Route::middleware(['auth:api', 'scopes:user'])->group(function (){
        // Content
        Route::get('content', [UserContentController::class, 'index']);
        Route::post('request-content', [UserContentController::class, 'uploade']);

        // Order
        Route::post('place-order', [OrderController::class, 'placeOrder']);
    });
});

/*
---------------------------------------------------------
    ADMIN ROUTES
----------------------------------------------------------
*/
Route::prefix('admin')->group(function (){
    Route::post('login', [AdminLoginController::class, 'login']);
    Route::post('forget-password', [AdminForgetPasswordController::class, 'forgetPassword']);
    Route::post('reset-password', [AdminForgetPasswordController::class, 'resetPassword']);

    //Protected route Both for Super Admin and Sub-admin
    Route::middleware(['auth:admin-api','scope:admin,sub-admin'])->group(function () {
        // Profile Routes
        Route::get('profile', [AdminController::class, 'profile']);
        Route::post('edit-profile', [AdminController::class, 'editProfile']);
        Route::post('change-password', [AdminController::class, 'changePassword']);
    });

    //Protected route Only for Super Admin
    Route::middleware(['auth:admin-api','scopes:admin'])->group(function () {
        //Users 
        Route::get('', [AdminController::class, 'index']);
        Route::get('users', [AdminController::class, 'getUsers']);
        Route::get('users/{id}', [AdminController::class, 'userDetails']);
        // Route::delete('users', [AdminController::class, 'deleteUsers']);
        Route::post('user-status', [AdminController::class, 'usersStatus']);

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
        Route::get('content/{id}', [ContentController::class, 'getContent']);
        Route::post('content', [ContentController::class, 'uploade'])->withoutMiddleware('throttle');
        Route::post('content-request', [ContentController::class, 'contentRequest']);
        Route::get('content-export', [ContentController::class, 'bulkExport'])->withoutMiddleware('throttle');

        // NewsLetter
        Route::get('news-letter', [NewsLetterController::class, 'index']);
        Route::get('news-letter/{id}', [NewsLetterController::class, 'singleNewsLetter']);
        // Route::get('news-letter-history', [NewsLetterController::class, 'newsletterHistory']);
        Route::post('news-letter', [NewsLetterController::class, 'sendNewsletterNotification']);

        // Orders
        Route::get('orders', [AdminOrderController::class, 'index']);
        Route::get('orders/{id}', [AdminOrderController::class, 'orderDetail']);

        // Assignment Orders
        Route::get('assignment', [AssignmentController::class, 'index']);
        Route::get('assignment/{id}', [AssignmentController::class, 'assignmentDetail']);
        // Route::get('assignment/{id}', [AssignmentController::class, 'orderDetail']);
        Route::post('assignment-status', [AssignmentController::class, 'updateStatus']);

        //Subject or Categories Management
        Route::get('subject',[SubjectController::class,'index']);
        Route::post('add-subject',[SubjectController::class,'addSubject']);
        Route::get('subject/{id}',[SubjectController::class,'getSubject']);
        Route::post('subject/{id}',[SubjectController::class,'editSubject']);
        Route::delete('subject/{id}',[SubjectController::class,'destroy']);

        //Manage Payment or Teacher Cool Weighage
        Route::get('admin-payment',[SystemSettingController::class,'index']);
        // Route::post('add-admin-payment',[SystemSettingController::class,'addPayment']);
        Route::post('admin-payment',[SystemSettingController::class,'editPayment']);
        
        //Order Payment Management
        Route::get('order-payment',[AssignmentPaymentController::class,'paymentList']);
        Route::get('single-order-payment',[AssignmentPaymentController::class,'singlePaymentTeacher']);
        Route::post('block-order-payment',[AssignmentPaymentController::class,'blockTeacherPayment']);

        Route::get('notification', [NotificationController::class, 'index']);
        Route::post('notification', [NotificationController::class, 'addNotification']);

    });
});