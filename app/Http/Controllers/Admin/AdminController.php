<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        return response()->json(['status' => 'success', 'code' => '200', 'user' => $user]);
    }
}
