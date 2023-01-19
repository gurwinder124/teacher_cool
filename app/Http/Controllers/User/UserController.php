<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        $user = Auth::user();
        if(!$user){
            sendError('Inavlid User', 401);
        }
        return response()->json(['status' => 'success', 'code' => '200', 'user' => $user]);
    }

    public function genrateReaffral(Request $request){
        try{
            
            $user = Auth::user();
            if($user->reffer_code == null){
                $user->reffer_code = $this->getString(10);
                $user->save();
            }
            

            return sendResponse($user->reffer_code);

        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
    }

    public function getString($n)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
     
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
     
        return $randomString;
    }
}
