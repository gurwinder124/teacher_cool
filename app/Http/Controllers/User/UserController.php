<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\TeacherSetting;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            $data = DB::table('users')
                    ->join('user_details', 'users.id', '=', 'user_details.user_id')
                    ->leftJoin('teacher_settings', 'users.id', '=', 'teacher_settings.user_id')
                    ->select('user_details.*','users.name','users.last_name','users.user_type','users.teacher_status','users.email','users.profile_path','users.teacher_id_number', 'teacher_settings.id_proof','teacher_settings.document_path','teacher_settings.working_hours','teacher_settings.expected_income','teacher_settings.category','teacher_settings.subject_id')
                    ->where('users.id', $user->id)
                    ->first();
            
            if(!$data){
                sendError('Inavlid User', 401);
            }
            return sendResponse($data);
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
    }

    public function editProfile(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|min:3',
                'contact' => 'required',
                'country' => 'required',
                'qualification' => 'required',
                'university' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['code' => '302', 'error' => $validator->errors()]);
            }

            $user = Auth::user();

            $userData = User::find($user->id);

            if ($request->file('profile_path')) {
                $extension = $request->file('profile_path')->getClientOriginalExtension();
                $fileName = time().'.'.$extension;
                $profile_path = $request->file('profile_path')->storeAs('profile',$fileName,'public');

                $userData->profile_path = $profile_path;
            }

            $userData->name = $request->first_name;
            $userData->last_name = $request->last_name;
            $userData->save();

            
            $data['contact'] = $request->contact;
            $data['gender'] = $request->gender;
            $data['age'] = $request->age;
            $data['city'] = $request->city;
            $data['state'] = $request->state;
            $data['country'] = $request->country;
            $data['qualification'] = $request->qualification;
            $data['university'] = $request->university;

            $userDetails = UserDetails::where('user_id',$user->id)
                            ->update($data);

            if($userDetails && $userData->user_type == User::STUDENT_TYPE){
                return sendResponse($userData, 'Profile Updated Successfully');
            }

            if($userData->user_type == User::TEACHER_TYPE){
                
                $teacherSettingData['user_id'] = $user->id;
                // $teacherSettingData['id_proof'] = $id_proof_path;
                // $teacherSettingData['document_path'] = $document_path; 
                $teacherSettingData['working_hours'] = $request->working_hours;
                $teacherSettingData['expected_income'] = $request->expected_income;
                $teacherSettingData['preferred_currency'] = $request->preferred_currency;
                $teacherSettingData['subject_id'] = $request->subject;
                $teacherSettingData['category'] = $request->category;

                
                if ($request->file('id_proof')) {
                    // $name = $request->file('id_proof')->getClientOriginalName();
                    $extension = $request->file('id_proof')->getClientOriginalExtension();
                    $originalfileName = $request->file('id_proof')->getClientOriginalName();
                    $originalfileName = pathinfo($originalfileName, PATHINFO_FILENAME);
                    $originalfileName = implode('-',explode(' ', $originalfileName));
                    $fileName = $originalfileName."-".time().'.'.$extension;

                    $teacherSettingData['id_proof'] = $request->file('id_proof')->storeAs('teacher',$fileName,'public');
                }

                if ($request->file('document_path')) {
                    // $name = $request->file('document_path')->getClientOriginalName();
                    $extension = $request->file('document_path')->getClientOriginalExtension();
                    $originalfileName = $request->file('document_path')->getClientOriginalName();
                    $originalfileName = pathinfo($originalfileName, PATHINFO_FILENAME);
                    $originalfileName = implode('-',explode(' ', $originalfileName));
                    $fileName = $originalfileName."-".time().'.'.$extension;

                    $teacherSettingData['document_path']  = $request->file('document_path')->storeAs('teacher',$fileName,'public');
                }

                $teacherSetting = TeacherSetting::where('user_id',$user->id)
                                    ->update($teacherSettingData);

                if($teacherSetting ){
                    return sendResponse([], 'Profile Updated Successfully');
                }
            }
            return sendError('Somthing went Wrong');
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }

    }

    public function changePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'current_password' => 'required',
                'new_password' => 'required|string|min:8|confirmed',
            ]);
            if ($validator->fails()) {
                return response()->json(['code' => '302', 'error' => $validator->errors()]);
            }

            if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
                // The passwords matches
                return sendError("Your current password is Incorrect.", [], 400);
            }

            if(strcmp($request->get('current_password'), $request->get('new_password')) == 0){
                // Current password and new password same
                return sendError("New Password cannot be same as your current password.", [], 400);
            }
            
            $user = Auth::user();

            $data = User::find($user->id);
            
            $data->password = Hash::make($request->new_password);
            $data->save();

            return sendResponse($data, 'Password Updated Successfully');
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }

    }


    public function genrateReaffral(Request $request)
    {
        try{
            
            $user = Auth::user();
            if($user->reffer_code == null){
                $user->reffer_code = getString(10);
                $user->save();
            }
            

            return sendResponse($user->reffer_code);

        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
    }

}
