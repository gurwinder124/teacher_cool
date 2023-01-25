<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use App\Models\Order;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Jobs\WelcomeSubAdmin;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        try{
            $user['teachers'] = User::where('user_type', User::TEACHER_TYPE)->count();
            $user['students'] = User::where('user_type', User::STUDENT_TYPE)->count();
            $user['orders'] = Order::where('is_paid', 1)->count();
            $user['earning'] = 0; // Code Pending
            return sendResponse($user);
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
        
    }

    public function getUsers(Request $request)
    {
        try{
            $keyword = $request->keyword;
            $user_type = $request->user_type;
            $gender = $request->gender;
            $age = $request->age;
            $sort = $request->sort;
            $page_size = ($request->page_size)? $request->page_size : 10;
            
            $data = DB::table('users')
                ->leftJoin('user_details', 'users.id', '=', 'user_details.user_id')
                ->leftJoin('subscribed_users', 'users.id', '=', 'subscribed_users.user_id')
                ->select('users.*', 'user_details.*','subscribed_users.name as subscription_name','subscribed_users.expire_date');
            if($keyword && $keyword != ''){
                $data = $data->where(function($query) use ($keyword){
                            $query->where('users.name', 'like', '%'.$keyword.'%')
                            ->orWhere('users.email', 'like', '%'.$keyword.'%')
                            ->orWhere('user_details.contact', 'like', '%'.$keyword.'%');
                        });
                
            }
            
            if($user_type){
                $data = $data->where('users.user_type', $user_type);
            }
            if($gender){
                $data = $data->where('user_details.gender', $gender);
            }
            if($age){
                $data = $data->where('user_details.age','<=', $age);
            }
            if($sort == 'asc'){
                $data = $data->orderBy('users.created_at');
            }else{
                $data = $data->orderByDesc('users.created_at');
            }
            $data = $data->paginate($page_size);
    
            return sendResponse($data);
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }

    }

    public function userDetails($id)
    {
        try{
            $data = DB::table('users')
                ->leftJoin('user_details', 'users.id', '=', 'user_details.user_id')
                ->leftJoin('subscribed_users', 'users.id', '=', 'subscribed_users.user_id')
                ->leftJoin('teacher_settings', 'users.id', '=', 'teacher_settings.user_id')
                ->select('users.*', 'user_details.*','subscribed_users.name as subscription_name',
                    'subscribed_users.expire_date','teacher_settings.document_path','teacher_settings.working_hours',
                    'teacher_settings.id_proof','teacher_settings.expected_income','teacher_settings.preferred_currency')
                ->where('users.id', $id)
                ->get();
    
            return sendResponse($data);
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
    }

    // public function deleteUsers(Request $request)
    // {
    //     try {
    //         $validator = Validator::make($request->all(), [
    //             'id' => 'required',
    //         ]);
    //         if ($validator->fails()) {
    //             return response()->json(['code' => '302', 'error' => $validator->errors()]);
    //         }
            
    //         User::destroy($request->id);
    //         DB::table('user_details')->where('user_id',$request->id)->delete();

    //         return sendResponse("User Deleted successfully.");

    //     } catch(\Exception $e) {
    //         return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
    //     }
    // }

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
            
            // $password = explode('@', $request->email)[0];
            $password = getString(4);
            // dd($password);

            $user = new Admin;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->contact = $request->contact;
            $user->address = ($request->address)? $request->address:"";
            $user->role = Admin::SUB_ADMIN;
            $user->password = Hash::make($password);
            $user->is_active = Admin::IS_ACTIVE;
            $user->save();

            // $admin=Admin::select('name','email')->where('id','=',1)->first();
            // $email=$admin->email;
            // $name=$admin->name;
            $data = [
                'to' =>  $request->email,
                'name' => $request->name,
                'password' => $password,
                'subject' => "Account Created"
            ];
            
            dispatch(new WelcomeSubAdmin($data))->afterResponse();
            return response()->json(['status' => 'Success', 'code' => 200, 'user' => $user]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
    }

    public function editSubAdmin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'name' => 'required|min:3',
                'contact' => 'required',
                'is_active' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['code' => '302', 'error' => $validator->errors()]);
            }

            $data = Admin::find($request->id);
            // dd($request->all());
            $data->name = $request->name;
            $data->contact = $request->contact;
            $data->is_active = $request->is_active;
            if($request->address){
                $data->address = $request->address;
            }
            $data->save();

            return sendResponse($data, 'Updated Successfully');
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
    }

    public function getSubAdmin(Request $request){
        try{
            $keyword = $request->keyword;
            $id = $request->id;
            $sort = $request->sort;
            $page_size = ($request->page_size)? $request->page_size : 10;

            if($id){
                $data = Admin::where('id', $id)
                        ->whereNot('role','=',0)->first();
            }else{
                $data = Admin::whereNot('role','=',0);
                if($keyword && $keyword != ''){
                    $data = $data->where('name', 'like', '%'.$keyword.'%')
                                ->orWhere('email', 'like', '%'.$keyword.'%');
                }

                if($sort == 'asc'){
                    $data = $data->orderBy('created_at');
                }else{
                    $data = $data->orderByDesc('created_at');
                }
                
                $data = $data->paginate($page_size);
            }
    
            return sendResponse($data);
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }

    }

    // public function deleteSubAdmin(Request $request)
    // {
    //     try {
    //         $validator = Validator::make($request->all(), [
    //             'id' => 'required',
    //         ]);
    //         if ($validator->fails()) {
    //             return response()->json(['code' => '302', 'error' => $validator->errors()]);
    //         }
    //         if($request->id == 1){
    //             return sendError('Cannot Perform the Action');
    //         }

    //         Admin::destroy($request->id);
            
    //         return sendResponse("Sub-Admin Deleted successfully.");

    //     } catch(\Exception $e) {
    //         return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
    //     }
    // }

    public function editProfile(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:3',
                'contact' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['code' => '302', 'error' => $validator->errors()]);
            }

            $user = Auth::user();

            $data = Admin::find($user->id);

            if ($request->file('profile_path')) {
                // $name = $request->file('profile_path')->getClientOriginalName();
                $extension = $request->file('profile_path')->getClientOriginalExtension();
                // $originalfileName = $request->file('profile_path')->getClientOriginalName();
                // $originalfileName = pathinfo($originalfileName, PATHINFO_FILENAME);
                // $originalfileName = implode('-',explode(' ', $originalfileName));
                $fileName = time().'.'.$extension;
                $profile_path = $request->file('profile_path')->storeAs('profile',$fileName,'public');

                $data->profile = $profile_path;
            }

            $data->name = $request->name;
            $data->contact = $request->contact;
            if($request->address){
                $data->address = $request->address;
            }
            $data->save();

            return sendResponse($data, 'Updated Successfully');
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
                return sendError("Your current password does not matches with the password.", [], 400);
            }

            if(strcmp($request->get('current_password'), $request->get('new_password')) == 0){
                // Current password and new password same
                return sendError("New Password cannot be same as your current password.", [], 400);
            }
            
            $user = Auth::user();

            $data = Admin::find($user->id);
            
            $data->password = Hash::make($request->new_password);
            $data->save();

            return sendResponse($data, 'Password Updated Successfully');
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }

    }
}
