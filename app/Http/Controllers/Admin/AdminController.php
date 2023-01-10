<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Hash;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        try{
            $user = Auth::user();
            return response()->json(['status' => 'success', 'code' => '200', 'user' => $user]);
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
        
    }

    public function getUsers(Request $request){
        try{
            $keyword = $request->keyword;
            $user_type = $request->user_type;
            
            $data = new User();
            if($keyword && $keyword != ''){
                $data = $data->where('name', 'like', '%'.$keyword.'%');
            }
            if($user_type){
                $data = $data->where('user_type', $user_type);
            }
            $data = $data->paginate(10);
    
            return sendResponse($data);
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
        

    }

    public function addSubAdmin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:admins',
                'name' => 'required|min:3',
                'contact' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['code' => '302', 'error' => $validator->errors()]);
            }

            $user = new Admin;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->contact = $request->contact;
            $user->role = Admin::SUB_ADMIN;
            $user->password = Hash::make("mind@123");
            $user->is_active = Admin::IS_ACTIVE;
            $user->save();
            // $admin=Admin::select('name','email')->where('id','=',1)->first();
            // $email=$admin->email;
            // $name=$admin->name;
            // $data = [
            //     'to' =>  $email,
            //     'name' => $name,
            //     'data' => "Thanks ",
            //     'subject' => "Account Created"
            // ];
            
            // dispatch(new SendNewRegisterEmail($data))->afterResponse();
            return response()->json(['status' => 'Success', 'code' => 200, 'user' => $user]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
    }

    public function getSubAdmin(Request $request){
        try{
            $keyword = $request->keyword;
        
            $data = Admin::whereNot('role','=',0);
            if($keyword && $keyword != ''){
                $data = $data->where('name', 'like', '%'.$keyword.'%');
            }
            
            $data = $data->paginate(10);
    
            return sendResponse($data);
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }

    }
}
