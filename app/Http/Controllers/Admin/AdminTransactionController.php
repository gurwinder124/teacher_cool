<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminTransaction;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    public function index()
    {
        try{
            $payment= AdminTransaction::first();
            if(!$payment){
                return sendError('No record Found');
            }
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
        return sendResponse($payment,200);
    }

    public function addPayment(Request $request)   
    {
        try {
            $validator = Validator::make($request->all(), [
                'teacher_cool_weightage' => 'required',
                // 'teacher_weightage' => 'required',
                'rate_per_assignment' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['code' => '302', 'error' => $validator->errors()]);
            }
            $payment = new AdminTransaction;
            $payment->teacher_cool_weightage=$request->teacher_cool_weightage;
            // $payment->teacher_weightage = $request->teacher_weightage;
            $payment->rate_per_assignment = $request->rate_per_assignment;
            $payment->discount = ($request->discount)? $request->discount : 0;
            $payment->save();
        } catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
        return sendResponse($payment,'Transaction added successfully');
    }

    public function editPayment($id,Request $request)
    {
        try{

            $validator = Validator::make($request->all(), [
                'teacher_cool_weightage' => 'required',
                // 'teacher_weightage' => 'required',
                'rate_per_assignment' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['code' => '302', 'error' => $validator->errors()]);
            }
            $payment = AdminTransaction::find($id);
            if(!$payment){
                return sendError('No record found');
            }
            $payment->teacher_cool_weightage=$request->teacher_cool_weightage;
            // $payment->teacher_weightage = $request->teacher_weightage;
            $payment->rate_per_assignment = $request->rate_per_assignment;
            $payment->discount = ($request->discount)? $request->discount : 0;
            $payment->save();

        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
        return sendResponse($payment,'Transaction updated successfully');
        

    }
}
