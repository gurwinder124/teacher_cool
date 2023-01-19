<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Validator;

use App\Models\Content;
use App\Models\User;

class UserContentController extends Controller
{
    public function index(Request $request)
    {
        try{
            $keyword = $request->keyword;
            
            $user = Auth::user();

            $data = Content::where('user_id', $user->id);
            if($keyword && $keyword != ''){
                $data = $data->where('name', 'like', '%'.$keyword.'%');
            }
            
            $data = $data->paginate(10);

            $response = [
                'success' => true,
                'data'    => $data,
                'message' => 'Success',
                'content_category' => Content::getContentCategory(),
            ];
        
            return response()->json($response, 200);
            
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
    }

    public function uploade(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'content_types_id' => 'required',
                'name' => 'required|min:3',
                'content_category' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => '302', 'error' => $validator->errors()]);
            }

            $user = Auth::user();

            if($user->user_type == User::TEACHER_TYPE){
                return response()->json(['code' => '302', 'error' => 'Teacher Can not upload Content']);
            }

            if ($request->file('file')) {
                // $name = $request->file('comment_attch')->getClientOriginalName();
                $extension = $request->file('file')->getClientOriginalExtension();
                $originalfileName = $request->file('file')->getClientOriginalName();
                $originalfileName = pathinfo($originalfileName, PATHINFO_FILENAME);
                $originalfileName = implode('-',explode(' ', $originalfileName));
                $fileName = $originalfileName.'.'.$extension;
                $path = $request->file('file')->storeAs('content',$fileName,'public');
                
                $attchObj = new Content;
                $attchObj->user_id = $user->id;
                $attchObj->content_types_id = $request->content_types_id;
                $attchObj->name =$request->name;
                $attchObj->content_category = $request->content_category;
                $attchObj->path = $path;
                $attchObj->uploaded_by_admin = 0;
                $attchObj->is_approved = 0;
                $attchObj->save();

                return sendResponse([], "Content Uploaded Successfully");
            }
            return response()->json(['code' => '302', 'error' => ["File"=>["The File field is required."]]]);

        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
    }

}
