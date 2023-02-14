<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Assignment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssignmentPaymentController extends Controller
{
    public function paymentList(Request $request)
    {
        try {
            $data = DB::table('users')
                ->join('assignments', 'users.id', '=', 'assignments.teacher_id')
                ->selectRaw('count(assignments.id) as assignments_count, users.name, users.email, assignments.teacher_id')
                ->groupBy('teacher_id')
                ->get();
            // return sendResponse($data);
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
        
    }

    public function singlePaymentTeacher($id)       
    {
        try {
            $teacherId = (int)$id;
            if($teacherId < 1 ){
                return sendError('Invalid Request');
            }
            $data = DB::table('users')
                ->join('assignments', 'users.id', '=', 'assignments.teacher_id')
                ->select('users.name', 'users.email','assignments.id','assignments.assignment_id', 'assignments.category','assignments.title', 'assignments.teacher_id', 'assignments.is_paid_to_teacher','assignments.assignment_status', 'assignments.due_date','assignments.answered_on')
                ->where('teacher_id', $teacherId)
                ->get();
                // return sendResponse($data);
            $response = [
                'success' => true,
                'data'    => $data,
                'message' => 'Success',
                'all_assignment_status' => Assignment::assignmentStatus(),
            ];
            return response()->json($response, 200);
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
        
    }
}
