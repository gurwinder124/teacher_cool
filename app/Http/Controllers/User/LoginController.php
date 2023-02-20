<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\AdminEmail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Hash;
use App\Models\UserDetails;
use App\Jobs\SendWelcomeEmail;
use App\Jobs\TeacherStatus;
use App\Models\SMS;
use App\Models\TeacherSetting;
use App\Models\Subject;
use Exception;
use Twilio\Rest\Client;

class LoginController extends Controller
{

    public function registerInfo()
    {
        try{
            $data['subjects'] = Subject::select('subject_name','id')->get();
            if(!$data){
                return sendError('No record Found');
            }
            return sendResponse($data);
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
    }

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
                    if ($user->user_type == User::TEACHER_TYPE) {
                        if($user->teacher_status == User::TEACHER_STATUS_PENDING){
                            $data['profile_status']  = 'pending';
                            return sendResponse($data, 'Your Profile is in Review');
                        }elseif($user->teacher_status == User::TEACHER_STATUS_DISAPPROVED){
                            $data['profile_status']  = 'rejected';
                            return sendResponse($data,'Unfortunately, Your Profile is Rejected');
                        }
                        $success['user_type']  = 'teacher';
                        $success['token'] = $user->createToken('accessToken', ['teacher'])->accessToken;
                    }
                    else{
                        $success['user_type']  = 'student';
                        $success['token'] = $user->createToken('accessToken', ['user'])->accessToken;
                    }
                    return sendResponse($success, 'You are successfully logged in.');
                    // return response()->json([$success, "msg"=> 'You are successfully logged in.']);
                }
                return sendError('Account not Activated',[], 403);
                
               
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
                'password' => 'required|min:4',
                'name' => 'required|min:3',
                'is_teacher_request' => 'required',
                'contact' => 'required',
               // 'city' => 'required',
               // 'state' => 'required',
                'country' => 'required',
                'qualification' => 'required',
               // 'university' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['code' => '302', 'error' => $validator->errors()]);
            }

            $profile_path = '';
            if ($request->file('profile')) {
                // $name = $request->file('comment_attch')->getClientOriginalName();
                $extension = $request->file('profile')->getClientOriginalExtension();
                // $originalfileName = $request->file('profile')->getClientOriginalName();
                // $originalfileName = pathinfo($originalfileName, PATHINFO_FILENAME);
                // $originalfileName = implode('-',explode(' ', $originalfileName));
                $fileName = time().'.'.$extension;
                $profile_path = $request->file('profile')->storeAs('profile',$fileName,'public');
            }

            $reffer_id = null;
            if($request->reffer_code){
                $refferUser = User::where('reffer_code','=',$request->reffer_code)->first();
                if($refferUser){
                    $reffer_id = $refferUser->id;
                }
            }

            $verifyCode = getString(10);
            
            /* Save User Data*/
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->user_type = User::STUDENT_TYPE;
            $user->is_active = User::IS_ACTIVE;
            $user->profile_path = $profile_path;
            $user->reffer_user_id = $reffer_id;
            $user->email_verify_code = $verifyCode;
            if($request->is_teacher_request){
                $user->teacher_status = User::TEACHER_STATUS_PENDING;
                $user->requested_for_teacher = 1;
		        $user->user_type =User::TEACHER_TYPE;
                $user->teacher_id_number  ='TCH-'.time();
            }
            
            $user->save();

            $id_proof_path = '';
            if ($request->file('id_proof')) {
                // $name = $request->file('comment_attch')->getClientOriginalName();
                $extension = $request->file('id_proof')->getClientOriginalExtension();
                // $originalfileName = $request->file('id_proof')->getClientOriginalName();
                // $originalfileName = pathinfo($originalfileName, PATHINFO_FILENAME);
                // $originalfileName = implode('-',explode(' ', $originalfileName));
                $fileName = time().'.'.$extension;
                $id_proof_path = $request->file('id_proof')->storeAs('teacher',$fileName,'public');
            }

            $document_path = '';
            if ($request->file('document_path')) {
                // $name = $request->file('comment_attch')->getClientOriginalName();
                $extension = $request->file('document_path')->getClientOriginalExtension();
                // $originalfileName = $request->file('document_path')->getClientOriginalName();
                // $originalfileName = pathinfo($originalfileName, PATHINFO_FILENAME);
                // $originalfileName = implode('-',explode(' ', $originalfileName));
                $fileName = time().'.'.$extension;
                $document_path = $request->file('document_path')->storeAs('teacher',$fileName,'public');
            }

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
            
            $saveUser= $userDetails->save();
            $saveTeacher = false;
            if($request->is_teacher_request){
                $teacherSetting = new TeacherSetting;
                $teacherSetting->user_id = $user->id;
                $teacherSetting->id_proof = $id_proof_path;
                $teacherSetting->document_path = $document_path; 
                $teacherSetting->working_hours = $request->working_hours;
                $teacherSetting->expected_income = $request->expected_income;
                $teacherSetting->preferred_currency = $request->preferred_currency;
                $teacherSetting->subject_id = $request->subject;
                $teacherSetting->category = $request->category;
                $saveTeacher=$teacherSetting->save();
            }
            $smsUserData =[
                'body'=> 'Register Successfully with Teacher Cool'
            ];
            $smsTeacherData =[
                'body'=> 'Your Request as Teacher is pending for confirmation. We will revert within 48 hrs'
            ];
            if($saveTeacher){
                // $this->sendSMS($smsTeacherData);   
            }elseif($saveUser){
                // $this->sendSMS($smsUserData);
            }
            
            $url = env('APP_URL_FRONT').'/verify-email/' . $verifyCode;
            // $url = url('/verify-email/').'/'. $verifyCode;
            
            $welcomedata=[
                'to'=> $request->email,
                'receiver_name'=> $request->name,
                'url'=> $url,
                'data' => 
                $saveTeacher? "Your Request as Teacher is pending for confirmation. We will revert within 48 hrs.Please verify your email from the link below:  " 
                :($saveUser? "Hope, You will have wonderful experience here.Please verify your email from the link below:":''),
                'subject' => "Regarding Welcome"
            ];
            dispatch(new SendWelcomeEmail($welcomedata))->afterResponse();

            return response()->json(['status' => 'Success', 'code' => 200, 'user' => $user]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
    }

    public function verifyEmail(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email_token' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['code' => '302', 'error' => $validator->errors()]);
            }

            $data = User::where('email_verify_code', '=', $request->email_token)->first();
            if(!$data){
                return sendError('No record Found');
            }
            $updateData = User::where('email_verify_code', '=', $request->email_token)
                    ->update(['email_verified_at' => date('Y-m-d H:i:s'), 'email_verify_code' => null]);
                    
            if($updateData && $data->requested_for_teacher){
                $teacherEmailData=[
                    'to'=>$data->email,
                    'receiver_name'=>$data->name,
                    'body' =>"Your Request as Teacher has been Pending for approval. We will revert you within 24hrs." ,
                    'subject' => "Regarding Approval Request"
                ];
                dispatch(new TeacherStatus($teacherEmailData))->afterResponse();
                $adminEmailData=[
                    'to'=> env('ADMIN_EMAIL_ADDRESS'),
                    'name'=>'Teacher Cool',
                    'body' =>"New teacher, ".$data->name." has been Register with ".$data->email." email." ,
                    'subject' => "Regarding Teacher Approval"
                ];
                dispatch(new AdminEmail($adminEmailData))->afterResponse();
            }

            if($updateData){
                // return view('verify-email',  ['isValid' => true]);
                return sendResponse('', 'Email Verified');
            }
            return sendError('Somthing went Wrong');
        } catch (Exception $e) {
            // return view('verify-email',  ['isValid' => false]);
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
    }

    // public function verifyEmail($code)
    // {
    //     try {
            
    //         $data = User::where('email_verify_code', '=', $code)->first();
            
    //         if(!$data){
    //             return view('verify-email', ['isValid' => false]);
    //         }
            
    //         $updateData = User::where('email_verify_code', '=', $code)
    //                 ->update(['email_verified_at' => date('Y-m-d H:i:s'), 'email_verify_code' => null]);
                    
    //         if($updateData && $data->requested_for_teacher){
    //             $teacherEmailData=[
    //                 'to'=>$data->email,
    //                 'receiver_name'=>$data->name,
    //                 'body' =>"Your Request as Teacher has been Pending for approval. We will revert you within 24hrs." ,
    //                 'subject' => "Regarding Approval Request"
    //             ];
    //             dispatch(new TeacherStatus($teacherEmailData))->afterResponse();
    //             $adminEmailData=[
    //                 'to'=> env('ADMIN_EMAIL_ADDRESS'),
    //                 'name'=>'Teacher Cool',
    //                 'body' =>"New teacher, ".$data->name." has been Register with ".$data->email." email." ,
    //                 'subject' => "Regarding Teacher Approval"
    //             ];
    //             dispatch(new AdminEmail($adminEmailData))->afterResponse();
    //         }
    //         if($updateData){
    //             return view('verify-email',  ['isValid' => true]);
    //         }
    //         return view('verify-email', ['isValid' => false]);
    //     } catch (Exception $e) {
    //         return view('verify-email',  ['isValid' => false]);
    //     }
    // }

    public function sendSMS($data){
       
        // $account_sid = env('TWILIO_APP_ID');
        // $auth_token = env('TWILIO_APP_KEY');
        
        // $twilio_number = env('TWILIO_APP_NUMBER');

        // $client = new Client($account_sid, $auth_token);
        // $client->messages->create(
        //     // Where to send a text message (your cell phone?)
        //     // $data['phone_number'],
        //     '+91 95015 60691',
        //     array(
        //         'from' => $twilio_number,
        //         'body' => $data['body']
        //     )
        // );
    }
    
}
