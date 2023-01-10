<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;

class AdminLoginController extends Controller
{
    public function login(Request $request)
    { 
        try {
            $validator = Validator::make($request->all(), [
                'email'    => 'required|email',
                'password' => 'required'
            ]);
            if ($validator->fails()) return response()->json( ['error' => $validator->errors(), 'code'=>'401']); 
            $credentials = $request->only('email', 'password');
            if (Auth::guard('admin')->attempt($credentials)) {
                $user = Auth::guard('admin')->user();
                
                $success['name']  = $user->name;
                $success['token'] = $user->createToken('accessToken', ['admin'])->accessToken;

                return response()->json(['status' => 'success', 'code' => '200', 'data' => $success]);
            } else {
                return response()->json(['status' => 'error', 'code' => '404', 'msg' => ' Invalid credential']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'code' => '401', 'msg' => $e->getmessage()]);
        }
    }

    
}
