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
    public function getPaymentList(Request $request)
    {
        try {
            $data = DB::table('users')
                ->join('assignments', 'users.id', '=', 'assignments.teacher_id')
                // ->select('users.name', 'users.email','assignments.assignment_id', 'assignments.category','assignments.title', 'assignments.teacher_id', 
                // 'assignments.is_paid_to_teacher','assignments.assignment_status', 'assignments.due_date')
                ->selectRaw('count(assignments.id) as assignments_count, users.name, users.email, assignments.teacher_id')
                ->groupBy('teacher_id')
                ->get();
        return sendResponse($data);
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
        
    }

    public function getSinglePayment($id)       
    {
        try {
            // $getPayment = OrderPayment::find($id);
            // return sendResponse($getPayment,200);
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
        
    }
}
