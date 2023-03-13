<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\TeacherSetting;
use App\Models\Subject;
use App\Models\ContentType;
use App\Models\Assignment;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Notifications\SystemNotification;

class UserController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            $data['user'] = DB::table('users')
                    ->join('user_details', 'users.id', '=', 'user_details.user_id')
                    ->leftJoin('teacher_settings', 'users.id', '=', 'teacher_settings.user_id')
                    ->select('user_details.*','users.name as first_name','users.last_name','users.user_type','users.teacher_status','users.email','users.profile_path','users.teacher_id_number', 'teacher_settings.id_proof','teacher_settings.document_path','teacher_settings.working_hours','teacher_settings.expected_income','teacher_settings.category','teacher_settings.subject_id','teacher_settings.preferred_currency','teacher_settings.experience','teacher_settings.experience_letter','teacher_settings.teacher_bio','teacher_settings.resubmit_data')
                    ->where('users.id', $user->id)
                    ->first();

            $data['all_subjects'] = Subject::
                                select('subject_name','id','category_id')
                                ->get();
            $data['subjects_by_category'] = $data['all_subjects']->groupBy(function($data) {
                                    return $data->category_id;
                                });
            $data['category_status'] = Content::getContentCategory();
            $data['experience_arr'] = User::experienceArr();
            
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
                // 'profile_path' => 'file|mimes:jpg,png,jpeg',
            ]);
            if ($validator->fails()) {
                return response()->json(['code' => '302', 'error' => $validator->errors()]);
            }

            $user = Auth::user();

            $userData = User::find($user->id);

            $is_resubmit = false;
            $new_data = [];

            if ($request->file('profile_path')) {
                $extension = $request->file('profile_path')->getClientOriginalExtension();
                $fileName = time().'.'.$extension;
                $profile_path = $request->file('profile_path')->storeAs('profile',$fileName,'public');

                $userData->profile_path = $profile_path;
            }

            if($userData->user_type == User::STUDENT_TYPE){
                $userData->name = $request->first_name;
                $userData->last_name = $request->last_name;
            }else{
                if($request->first_name != $userData->name){
                    $new_data['first_name'] = $request->first_name;
                    $is_resubmit = true;
                }
                if($request->last_name != $userData->last_name){
                    $new_data['last_name'] = $request->last_name;
                    $is_resubmit = true;
                }
            }
            
            $userData->save();

            // Edit User Details 
            $userDetailsData = UserDetails::where('user_id',$user->id)
                            ->select('contact')
                            ->first();
            $data = [];
            if($userData->user_type == User::STUDENT_TYPE){
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

                if($userDetails){
                    return sendResponse($userData, 'Profile Updated Successfully');
                }
            }else{
                if($request->contact != $userDetailsData->contact){
                    $new_data['contact'] = $request->contact;
                    $is_resubmit = true;
                }
                if($request->qualification != $userDetailsData->qualification){
                    $new_data['qualification'] = $request->qualification;
                    $is_resubmit = true;
                }
                // if($request->gender != $userDetailsData->gender){
                //     $new_data['gender'] = $request->gender;
                //     $is_resubmit = true;
                // }
                // if($request->age != $userDetailsData->age){
                //     $new_data['age'] = $request->age;
                //     $is_resubmit = true;
                // }
                // if($request->city != $userDetailsData->city){
                //     $new_data['city'] = $request->city;
                //     $is_resubmit = true;
                // }
                // if($request->state != $userDetailsData->state){
                //     $new_data['state'] = $request->state;
                //     $is_resubmit = true;
                // }
                if($request->country != $userDetailsData->country){
                    $new_data['country'] = $request->country;
                    $is_resubmit = true;
                }

                $data['gender'] = $request->gender;
                $data['age'] = $request->age;
                $data['city'] = $request->city;
                $data['state'] = $request->state;
                $userDetails = UserDetails::where('user_id',$user->id)
                            ->update($data);
            }
            

            if($userData->user_type == User::TEACHER_TYPE){

                // $teacherSettingData['user_id'] = $user->id;
                // $teacherSettingData['working_hours'] = $request->working_hours;
                // $teacherSettingData['expected_income'] = $request->expected_income;
                // $teacherSettingData['preferred_currency'] = $request->preferred_currency;
                // $teacherSettingData['subject_id'] = $request->subject;
                // $teacherSettingData['category'] = $request->category;
                // $teacherSettingData['experience'] = $request->experience;
                $teacherSettingData['teacher_bio'] = $request->teacher_bio;
                
                // if ($request->file('id_proof')) {
                //     $extension = $request->file('id_proof')->getClientOriginalExtension();
                //     $originalfileName = $request->file('id_proof')->getClientOriginalName();
                //     $originalfileName = pathinfo($originalfileName, PATHINFO_FILENAME);
                //     $originalfileName = implode('-',explode(' ', $originalfileName));
                //     $fileName = $originalfileName."-".time().'.'.$extension;

                //     $teacherSettingData['id_proof'] = $request->file('id_proof')->storeAs('teacher',$fileName,'public');
                //     $is_resubmit = true;
                // }

                // if ($request->file('document_path')) {
                //     $extension = $request->file('document_path')->getClientOriginalExtension();
                //     $originalfileName = $request->file('document_path')->getClientOriginalName();
                //     $originalfileName = pathinfo($originalfileName, PATHINFO_FILENAME);
                //     $originalfileName = implode('-',explode(' ', $originalfileName));
                //     $fileName = $originalfileName."-".time().'.'.$extension;

                //     $teacherSettingData['document_path']  = $request->file('document_path')->storeAs('teacher',$fileName,'public');
                //     $is_resubmit = true;
                // }

                if ($request->file('experience_letter')) {
                    $extension = $request->file('experience_letter')->getClientOriginalExtension();
                    $originalfileName = $request->file('experience_letter')->getClientOriginalName();
                    $originalfileName = pathinfo($originalfileName, PATHINFO_FILENAME);
                    $originalfileName = implode('-',explode(' ', $originalfileName));
                    $fileName = $originalfileName."-".time().'.'.$extension;

                    $teacherSettingData['experience_letter'] = $request->file('experience_letter')->storeAs('teacher',$fileName,'public');
                }

                if($request->working_hours != $userDetailsData->working_hours){
                    $new_data['working_hours'] = $request->working_hours;
                    $is_resubmit = true;
                }
                if($request->expected_income != $userDetailsData->expected_income){
                    $new_data['expected_income'] = $request->expected_income;
                    $is_resubmit = true;
                }
                if($request->preferred_currency != $userDetailsData->preferred_currency){
                    $new_data['preferred_currency'] = $request->preferred_currency;
                    $is_resubmit = true;
                }
                if($request->subject_id != $userDetailsData->subject_id){
                    $new_data['subject_id'] = $request->subject_id;
                    $is_resubmit = true;
                }
                if($request->category != $userDetailsData->category){
                    $new_data['category'] = $request->category;
                    $is_resubmit = true;
                }
                if($request->experience != $userDetailsData->experience){
                    $new_data['experience'] = $request->experience;
                    $is_resubmit = true;
                }

                $teacherSettingData['resubmit_data'] = json_encode($new_data);

                $teacherSetting = TeacherSetting::where('user_id',$user->id)
                                    ->update($teacherSettingData);

                if($teacherSetting ){
                    if($is_resubmit){
                        $userReq = User::where('id',$user->id)
                            ->update(['teacher_status'=>User::TEACHER_STATUS_RESUBMIT]);
                    }

                    // send email to Admin
                    
                }
                return sendResponse([], 'Profile Updated Successfully');
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
                return sendError("New password cannot be same as your current password.", [], 400);
            }
            
            $user = Auth::user();

            $data = User::find($user->id);
            
            $data->password = Hash::make($request->new_password);
            $data->save();

            return sendResponse($data, 'Password updated successfully');
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


    public function notification(Request $request)
    {
        try{
            $user = Auth::user();
            $notificationData = [];
            foreach ($user->notifications as $notification) {
                if($notification->data){
                    array_push($notificationData, $notification->data);
                }
            }
            return sendResponse($notificationData);
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
    }

    public function search(Request $request)
    {
        try{
            $keyword = $request->keyword;
            $page_size = ($request->page_size)? $request->page_size : 10;
            $sort = $request->sort;

            if(strtolower($keyword) == 'it'){
                $keyword = 1;
            }elseif(strtolower($keyword) == 'nonit' || strtolower($keyword) == 'non-it'){
                $keyword = 2;
            }
            $data = DB::table('contents')
                    ->leftJoin('users','users.id', '=', 'contents.user_id')
                    ->select('contents.*', 'users.name as teacher_name');
            if($keyword && $keyword != ''){
                $data = $data->where(function($query) use ($keyword){
                            $query->where('contents.name', 'like', '%'.$keyword.'%')
                            ->orWhere('contents.description', 'like', '%'.$keyword.'%')
                            ->orWhere('contents.content_category', $keyword);
                        });
            }

            if($sort == 'desc'){
                $data = $data->orderByDesc('contents.name');
            }else{
                $data = $data->orderBy('contents.name');
            }

            $data = $data->paginate($page_size);

            $response = [
                'success' => true,
                'data'    => $data,
                'message' => 'Success',
                'content_category' => Content::getContentCategory(),
                'content_type' => ContentType::select('id','name')->get(),
            ];
        
            return response()->json($response, 200);
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
    }

    public function statsInfo()
    {
        try{
            $assignments = DB::table('assignments')
                            ->join('users as teacher', 'teacher.id', '=', 'assignments.teacher_id');
            $totalAssignment =  $assignments->get()->count();
            $assignmentAnswered = $assignments->where('assignment_status', Assignment::ASSIGNMENT_STATUS_SUBMITTED)
                                ->get()->count();
            $assignmentApproved = $assignments->where('assignment_status', Assignment::ASSIGNMENT_STATUS_APPROVED)
                                ->get()->count();

            $user = Auth::user();
            $data['name'] =  $user->name;
            $data['total_earnings'] =  1000;
            $data['total_assignments'] =  $totalAssignment;
            $data['assignment_answered'] =  $assignmentAnswered;
            $data['assignment_approved'] =  $assignmentApproved;
           
            return sendResponse($data);
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
    }

}
