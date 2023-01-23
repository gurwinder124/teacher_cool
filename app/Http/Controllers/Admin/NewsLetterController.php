<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Models\User;
use App\Models\EmailTemplate;
use App\Models\EmailHistory;
use App\Jobs\NewsLetter;

class NewsLetterController extends Controller
{
    public function index(Request $request)
    {
        try{
            
            $data = EmailTemplate::where('slug', EmailTemplate::NEWSLETTER_EMAIL)->first();
        
            return sendResponse($data);
            
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
    }

    public function newsletterHistory(Request $request)
    {
        try{
            $start = $request->start;
            $end = $request->end;

            $data = EmailHistory::where('email_type', EmailTemplate::NEWSLETTER_EMAIL);
            if($start){
                $data = $data->where('created_at', '>=', $start);
            }
            if($end){
                $data = $data->where('created_at', '<=', $end);
            }

            $data = $data->get();
        
            return sendResponse($data);
            
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
    }

    public function sendNewsletterNotification(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'message' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => '302', 'error' => $validator->errors()]);
            }

            $users = User::where('is_newsletter_subscriber', '=', 1)
                        ->select(['email'])->get()->toarray();
            // dd($users);
            $data = new EmailHistory;
           
            $data->email_type = EmailTemplate::NEWSLETTER_EMAIL;
            $data->message = $request->message;
            $data->save();

            $newsLetterData = [
                'to' => "gurwinder11@yopmail.com",
                'users' => $users,
                'body' => $request->message,
                'subject' => $request->subject,
            ];
            
            dispatch(new NewsLetter($newsLetterData))->afterResponse();

            return sendResponse([], 'Success');
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
    }
}
