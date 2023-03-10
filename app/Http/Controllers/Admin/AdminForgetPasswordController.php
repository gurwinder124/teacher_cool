<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Exception;
class AdminForgetPasswordController extends Controller
{
    public function forgetPassword(Request $request)
    {
        try {
            $user = Admin::where('email', $request->email)->get();
            if (count($user) > 0) {
                $token = Str::random(40);

                $url = '/reset-password?token=' . $token;

                $name = $user[0]['name'];
                $user['to'] = $request->email;
                
                $data = [
                    'url' => $url,
                    'name' => $name,
                    'email' => $request->email,
                    'title' => "Reset password"
                ];

                // Mail::send('forgetPasword', $data, function ($message) use ($user) {
                //     $message->to($user['to'])->subject('Regarding password reset');
                // });
                $datetime = Carbon::now()->format('Y-m-d H:i:s');
                PasswordReset::updateOrCreate(
                    ['email' => $request->email],
                    [
                        'token' => $token,
                        'created_at' => $datetime
                    ]

                );
                return response()->json(['status' => 'success', 'code' => '200', 'msg' => 'Plaese check your mail to  reset your password']);
            } else {
                return response()->json(['status' => 'error', 'code' => '400', 'data' => 'user not found']);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'code' => '500', 'message' => $e->getmessage()]);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'password' => 'required|string|confirmed',
                'token' => 'required|string'
            ]);
            if ($validator->fails()) {
                return response()->json(['code' => '302', 'error' => $validator->errors()]);
            }

            $resetData = DB::table('reset_code_passwords')
                    ->select('email')
                    ->where('token', $request->token)
                    ->first();
            if(!$resetData){
                return response()->json(['code' => '302', 'error' => 'Token not found']);
            }
            $user = Admin::where('email',$resetData->email)->first();
            $user->password = Hash::make($request->password);
            $user->save();
            PasswordReset::where('email', $user->email)->delete();
            return response()->json(['status' => 'success', 'code' => '200', 'msg' => "Password updated"]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'code' => '500', 'message' => $e->getmessage()]);
        }
    }
}
