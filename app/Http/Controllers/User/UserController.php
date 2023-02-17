<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            $data = DB::table('users')
                    ->join('user_details', 'users.id', '=', 'user_details.user_id')
                    ->leftJoin('teacher_settings', 'users.id', '=', 'teacher_settings.user_id')
                    ->select('user_details.*','users.name','users.email','users.profile_path','users.teacher_id_number', 'teacher_settings.id_proof','teacher_settings.document_path','teacher_settings.working_hours','teacher_settings.expected_income','teacher_settings.category','teacher_settings.subject_id')
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
                'name' => 'required|min:3',
                'contact' => 'required',
                'gender' => 'required',
                'age' => 'required',
                'city' => 'required',
                'state' => 'required',
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

            $userData->name = $request->name;
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

            if($userDetails){
                return sendResponse($userData, 'Updated Successfully');
            }
            return sendError('Somthing went Wrong');
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
