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
use Exception;
use Twilio\Rest\Client;

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
                    // dd("test");
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
		        $user->user_type =User::TEACHER_TYPE;;
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
                $teacherSetting->subject = $request->subject;
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
            $welcomedata=[
                'to'=>$request->email,
                'name'=>$request->name,
                'verifyCode'=>$verifyCode,
                'data' => 
                $saveTeacher? "Your Request as Teacher is pending for confirmation. We will revert within 48 hrs.Please verify your email from the link below:  " 
                :($saveUser? "Hope, You will have wonderful experience here.Please verify your email from the link below:":''),
                'subject' => "Regarding Welcome"
            ];
            // dispatch(new SendNewRegisterEmail($data))->afterResponse();
            dispatch(new SendWelcomeEmail($welcomedata))->afterResponse();
            return response()->json(['status' => 'Success', 'code' => 200, 'user' => $user]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
    }

    public function verifyEmail(Request $request){
        $email_code = $request->code;

        if(!$email_code) {
            echo sendError("Invalid Link", '302');
            die;
        }

        $data = User::where('email_verify_code', '=', $email_code)->first();
        
        if(!$data){
            echo sendError("Invalid Link", [], '302');
            die;
        }

        $updateData = User::where('email_verify_code', '=', $email_code)
                ->update(['email_verified_at' => date('Y-m-d H:i:s'), 'email_verify_code' => null]);
        if($updateData){
            $teacherEmailData=[
                'to'=>$data->email,
                'name'=>$data->name,
                'body' =>"Your Request as Teacher has been Pending for approval. We will revert you within 24hrs." ,
                'subject' => "Regarding Approval Request"
            ];
            dispatch(new TeacherStatus($teacherEmailData))->afterResponse();
            $adminEmailData=[
                'to'=>'teachercool@yopmail.com',
                'name'=>'Teacher Cool',
                'body' =>"New teacher, ".$data->name." has been Register with ".$data->email." email." ,
                'subject' => "Regarding Teacher Approval"
            ];
            dispatch(new AdminEmail($adminEmailData))->afterResponse();
        }

        // return sendResponse([], "Email Verified");
        $html =  `<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Teacher Cool</title>
        </head>
        <body>
            <h1>Verification Completed</h1>
        </body>
        </html>
        
        `;
        echo $html;
        die;
        
        
    }

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
