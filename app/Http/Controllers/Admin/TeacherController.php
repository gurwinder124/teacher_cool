<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Exception;
class TeacherController extends Controller
{
    public function index(Request $request)
    {
        try{
            $keyword = $request->keyword;
            
            $data = User::where('teacher_status', User::TEACHER_STATUS_PENDING)
                        ->where('requested_for_teacher', 1);
            if($keyword && $keyword != ''){
                $data = $data->where('name', 'like', '%'.$keyword.'%');
            }
            
            $data = $data->paginate(10);

            $response = [
                'success' => true,
                'data'    => $data,
                'teacher_status' => User::teacherRequestStatus(),
                'message' => 'Success',
            ];
        
            return response()->json($response, 200);
            
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
    }

    public function changeStatus(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'status' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['code' => '302', 'error' => $validator->errors()]);
            }

            $data = User::find($request->id);
            if(!$data){
                return sendError("Invalid Record");
            }
            
            $data->teacher_status = $request->status;
            if($request->status == User::TEACHER_STATUS_APPROVED){
                $data->user_type = User::TEACHER_TYPE;
            }
            $data->save();

            //Send email Notification Pending

            return sendResponse($data, 'Updated Successfully');
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
    }
}
