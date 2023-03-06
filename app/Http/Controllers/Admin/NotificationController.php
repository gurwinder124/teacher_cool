<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\NotificationModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use Exception;
use App\Notifications\SystemNotification;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        
        try{
            $page_size = $request->page_size ? $request->page_size : 10;

            $data = DB::table('notifications')
                ->join('users', 'users.id', '=', 'notifications.notifiable_id')
                ->selectRaw('notifications.*, users.name as first_name, users.last_name as last_name,users.user_type,(CASE 
                WHEN users.user_type = "1" THEN "Teacher" 
                ELSE "Student" 
                END) AS user_type_name')
                ->orderBy('notifications.created_at')
                ->paginate($page_size);

            if(!$data){
                return sendError('No record Found');
            }

            $response = [
                'success' => true,
                'data'    => $data,
                'message' => 'Success',
            ];
            return response()->json($response, 200);
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
    }
    
    public function addNotification(Request $request)
    {
        try{
         
            $validator = Validator::make($request->all(), [
                'notify_to' => 'required',
                'notification_type' => 'required',
                'title' => 'required',
                'message' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['code' => '302', 'error' => $validator->errors()]);
            }

            $userData  = User::where('is_active', 1)
                        ->where('email_verified_at', '!=', null);
            
            if($request->notify_to == NotificationModel::NOTIFY_TO_TEACHER){
                $userData = $userData->where('user_type', User::TEACHER_TYPE);
            }else if($request->notify_to == NotificationModel::NOTIFY_TO_STUDENT){
                $userData = $userData->where('user_type', User::STUDENT_TYPE);
            }

            $userData = $userData->get();
            // dd($userData);

            $data = [
                'title' => $request->title,
                'message' => $request->message
            ];

            if($request->notification_type == NotificationModel::PUSH_NOTIFICATION){
                Notification::sendNow($userData, new SystemNotification($data));
            }else{
                dd('email notification');
            }
            return sendResponse("Notification Sent Successfully");
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }

    }
}
