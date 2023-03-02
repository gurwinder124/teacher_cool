<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use App\Models\BillingInfo;

class BillingInfoController extends Controller
{
    public function index()
    {
       try{
            $user = Auth::user();
            
            $data = DB::table('billing_infos')
                ->join('users', 'users.id', '=', 'billing_infos.teacher_id')
                ->select('billing_infos.*', 'users.name as first_name', 'users.last_name')
                ->where('billing_infos.teacher_id', '=', $user->id)
                ->first();
            return sendResponse($data);
       }catch(Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
       }
    }

    public function addBillingInfo(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'bank_name' => 'required',
                'account_number' => 'required',
                'ifsc_code' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => '302', 'error' => $validator->errors()]);
            }

            $user = Auth::user();
            $billingInfo = BillingInfo::where('teacher_id', $user->id)->first();
            

            $data['bank_name'] = $request->bank_name;
            $data['account_number'] = $request->account_number;
            $data['ifsc_code'] = $request->ifsc_code;
            $data['firm_name'] = $request->firm_name;
            $data['gst_number'] = $request->gst_number;

            if(!$billingInfo){
                $data['teacher_id'] = $user->id;
                $result = BillingInfo::create($data);
            }else{
                $result = BillingInfo::where('teacher_id', $user->id)->update($data);
            }

            return sendResponse($result,"Updated Successfully");
       }catch(Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
       }
    }
}
