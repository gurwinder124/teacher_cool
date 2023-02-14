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
            $data = DB::table('assignments')
                ->join('users', 'users.id', '=', 'assignments.teacher_id')
                ->select('users.name as teacher_name', 'users.email as teacher_email','users.name as teacher_name',
                'assignments.assignment_id', 'assignments.category','assignments.title', 'assignments.teacher_id', 
                'assignments.is_paid_to_teacher','assignments.assignment_status', 'assignments.due_date')
                ->where('assignments.assignment_status', Assignment::ASSIGNMENT_STATUS_APPROVED)
                ->get();
                // ->groupBy(function($data) {
                //     return $data->teacher_id;
                // });
        return sendResponse($data);
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
        
    }

    public function getSinglePayment($id)       
    {
        try {
            $getPayment = OrderPayment::find($id);
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
        return sendResponse($getPayment,200);
    }
}
