<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\TeacherStatus;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        try{
            $keyword = $request->keyword;
            $sort = $request->sort;
            $page_size = ($request->page_size)? $request->page_size : 10;

            
            $data = DB::table('users')
                ->leftJoin('teacher_settings', 'users.id', '=', 'teacher_settings.user_id')
                ->select('users.*','teacher_settings.id_proof','teacher_settings.document_path','teacher_settings.expected_income',
                'teacher_settings.preferred_currency','teacher_settings.subject','teacher_settings.category')
                ->where('users.requested_for_teacher', 1)
                ->where('users.teacher_status', User::TEACHER_STATUS_PENDING);

            if($keyword && $keyword != ''){
                $data = $data->where(function($query) use ($keyword){
                            $query->where('users.name', 'like', '%'.$keyword.'%')
                            ->orWhere('users.email', 'like', '%'.$keyword.'%');
                        });
            }

            if($sort == 'asc'){
                $data = $data->orderBy('users.created_at');
            }else{
                $data = $data->orderByDesc('users.created_at');
            }
            $data = $data->paginate($page_size);

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
                $welcomeData=[
                    'to'=>$data->email,
                    'name'=>$data->name,
                    'body' =>"Your Request as Teacher has been approved. Please login with your credentials." ,
                    'subject' => "Regarding Approval"
                ];
                dispatch(new TeacherStatus($welcomeData))->afterResponse();
            }
            if($request->status == User::TEACHER_STATUS_DISAPPROVED){
                $rejectData=[
                    'to'=>$data->email,
                    'name'=>$data->name,
                    // 'verifyCode'=>$verifyCode,
                    'body' =>"Unfortunately your request has been disapproved." ,
                    'subject' => "Regarding Disapproval"
                ];
                dispatch(new TeacherStatus($rejectData))->afterResponse();
            }
            $data->save();

            //Send email Notification Pending


            return sendResponse($data, 'Updated Successfully');
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
    }
}
