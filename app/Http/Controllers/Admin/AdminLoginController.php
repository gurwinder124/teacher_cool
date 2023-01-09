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
            //    dd($credentials);
            if (\Auth::guard('admin')->attempt($credentials)) {
                $user = Auth::guard('admin')->user();
                // dd($user);
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

    public function addAdmin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:admins',
                'password' => 'required',
                'name' => 'required|min:3',
            ]);
            if ($validator->fails()) {
                return response()->json(['code' => '302', 'error' => $validator->errors()]);
            }

            $admin = new Admin;
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->password = Hash::make($request->password);
            $admin->save();
            // $admin=Admin::select('name','email')->where('id','=',1)->first();
            // $email=$admin->email;
            // $name=$admin->name;
            // $data = [
            //     'to' =>  $email,
            //     'name' => $name,
            //     'company_name' =>$request->company_name,
            //     'data' => "Thanks ",
            //     'subject' => "Regarding Register new User"
            // ];
            // $welcomedata=[
            //     'to'=>$request->email,
            //     'name'=>$request->first_name,
            //     'data' => "Thanks ",
            //     'subject' => "Regarding Welcome"
            // ];
            // dispatch(new SendNewRegisterEmail($data))->afterResponse();
            // dispatch(new SendWelcomeEmail($welcomedata))->afterResponse();
            return response()->json(['status' => 'Success', 'code' => 200, 'user' => $user]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
    }
}
