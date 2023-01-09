<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $user = Auth::user();
        if(!$user){
            sendError('Inavlid User', 401);
        }
        return response()->json(['status' => 'success', 'code' => '200', 'user' => $user]);
    }
}
