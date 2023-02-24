<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\LoginController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/test', function () {
//     return view('emails.newsletter');
// });

// Route::get('verify-email/{code}', [LoginController::class, 'verifyEmail']);
