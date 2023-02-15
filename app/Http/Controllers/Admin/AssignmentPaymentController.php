<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Assignment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Content;
use Illuminate\Support\Facades\Validator;

class AssignmentPaymentController extends Controller
{
    public function paymentList(Request $request)
    {
        try {
            $keyword = $request->keyword;
            $start_date = ($request->start_date)? date("Y-m-d", strtotime($request->start_date)): null;
            $end_date = ($request->end_date)? date("Y-m-d", strtotime($request->end_date)): null;

            $data = DB::table('users')
                ->join('assignments', 'users.id', '=', 'assignments.teacher_id')
                ->selectRaw('count(assignments.id) as assignments_count, users.name, users.email, assignments.teacher_id, assignments.answered_on_date ');
            if($keyword && $keyword != ''){
                $data = $data->where(function($query) use ($keyword){
                            $query->where('users.name', 'like', '%'.$keyword.'%')
                            ->orWhere('users.email', 'like', '%'.$keyword.'%');
                        });
            }
            if($start_date && $start_date != ''){
                $data = $data->where('assignments.answered_on_date','>=', $start_date);
            }

            if($end_date && $end_date != ''){
                $data = $data->where('assignments.answered_on_date','<=', $end_date);
            }

            $data = $data->groupBy('teacher_id','assignments.answered_on_date')->get();

            return sendResponse($data);
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
        
    }

    public function singlePaymentTeacher(Request $request)       
    {
        try {
            $teacher_id = $request->teacher_id;
            $date = ($request->date)? date("Y-m-d", strtotime($request->date)): null;
            
            if($teacher_id < 1 || $date == null){
                return sendError('Invalid Request');
            }
            $data = DB::table('users')
                ->join('assignments', 'users.id', '=', 'assignments.teacher_id')
                ->select('users.name', 'users.email','assignments.id','assignments.amount', 'assignments.assignment_id', 'assignments.category','assignments.title', 'assignments.teacher_id', 'assignments.is_paid_to_teacher','assignments.assignment_status', 'assignments.due_date','assignments.answered_on_date','assignments.answered_on_time')
                ->where('teacher_id', $teacher_id)
                ->where('assignments.answered_on_date','=', $date)
                ->get();
                // return sendResponse($data);
            $response = [
                'success' => true,
                'data'    => $data,
                'message' => 'Success',
                'all_assignment_status' => Assignment::assignmentStatus(),
                'category_status' => Content::getContentCategory(),
            ];
            return response()->json($response, 200);
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
        
    }


    public function blockTeacherPayment(Request $request)       
    {
        try {
            $validator = Validator::make($request->all(), [
                'assignment_id' => 'required|integer',
                'block_status' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => '302', 'error' => $validator->errors()]);
            }

            $assignment_id = $request->assignment_id;
            $status = $request->block_status;

            if($status != 0 && $status !=  1){
                return sendError('Invalid Request');
            }

            if($assignment_id < 1){
                return sendError('Invalid Request');
            }

            $data = Assignment::find($assignment_id);
            if(!$data){
                return sendError('Invalid Request', [], 404);
            }
            $data->is_payment_block = $status;
            $data->save();

            return sendResponse('Status Updated Successfully');
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
        
    }
}
