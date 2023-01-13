<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Hash;
use App\Models\UserDetails;
class LoginController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email'    => 'required|email',
                'password' => 'required'
            ]);

            if ($validator->fails()) return sendError('Validation Error.', $validator->errors(), 422);

            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $user= Auth::user();
                
                if($user->is_active && $user->email_verified_at != null){
                    
                    $success['user']  = $user;
                    if ($user->teacher_status == User::TEACHER_STATUS_APPROVED) {
                        $success['user_type']  = 'teacher';
                        $success['token'] = $user->createToken('accessToken', ['teacher'])->accessToken;
                    }
                    else{
                        $success['user_type']  = 'student';
                        $success['token'] = $user->createToken('accessToken', ['user'])->accessToken;
                    }
                    return response()->json([$success, "msg"=> 'You are successfully logged in.']);
                }
                return sendError('Account not Activated');
                
               
            }else {
                return response()->json( ['error' => 'invalid credentials', 'code'=>'401']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'code' => '401', 'msg' => 'You  are not authorised']);
        }
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'name' => 'required|min:3',
                'is_teacher_request' => 'required',
                'contact' => 'required',
                'city' => 'required',
                'state' => 'required',
                'country' => 'required',
                'qualification' => 'required',
                'university' => 'required',
                'gender'=> 'required',
                'age' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['code' => '302', 'error' => $validator->errors()]);
            }

            
            /* Save User Data*/
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->user_type = User::STUDENT_TYPE;
            $user->is_active = User::IS_ACTIVE;
            if($request->is_teacher_request){
                $user->teacher_status = User::TEACHER_STATUS_PENDING;
                $user->requested_for_teacher = 1;
            }
            
            $user->save();

            /* Save User Details*/
            $userDetails = new UserDetails;
            $userDetails->user_id = $user->id;
            $userDetails->contact = $request->contact;
            $userDetails->city =  $request->city;
            $userDetails->state = $request->state;
            $userDetails->country = $request->country;
            $userDetails->qualification = $request->qualification;
            $userDetails->university = $request->university; 
            $userDetails->gender = $request->gender;
            $userDetails->age = $request->age; 
            
            $userDetails->save();
            
            
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
