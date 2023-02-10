<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderPayment;
use Exception;
use Illuminate\Http\Request;

class OrderPaymentController extends Controller
{
    public function getPaymentList(Request $request)
    {
        try {
            $getPaymentList = OrderPayment::get();
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
        return sendResponse($getPaymentList,200);
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
