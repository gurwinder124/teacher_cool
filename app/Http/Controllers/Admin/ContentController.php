<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\ContentType;
use App\Models\Reward;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        try{
            $keyword = $request->keyword;
            $sort = $request->sort;
            $page_size = ($request->page_size)? $request->page_size : 10;

            $data = DB::table('contents')
                    ->leftJoin('users','users.id', '=', 'contents.user_id')
                    ->select('contents.*', 'users.name as teacher_name');
            if($keyword && $keyword != ''){
                $data = $data->where('contents.name', 'like', '%'.$keyword.'%');
            }
            if($sort == 'asc'){
                $data = $data->orderBy('contents.created_at');
            }else{
                $data = $data->orderByDesc('contents.created_at');
            }
            $data = $data->paginate($page_size);

            $response = [
                'success' => true,
                'data'    => $data,
                'message' => 'Success',
                'content_category' => Content::getContentCategory(),
                'content_type' => ContentType::select('id','name')->get(),
                'content_status' => Content::getContentStatus(),
            ];
        
            return response()->json($response, 200);
            
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
    }

    public function uploade(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'content_types_id' => 'required',
                'name' => 'required|min:3',
                'content_category' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => '302', 'error' => $validator->errors()]);
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
                $attchObj->content_types_id = $request->content_types_id;
                $attchObj->name =$request->name;
                $attchObj->content_category = $request->content_category;
                $attchObj->path = $path;
                $attchObj->uploaded_by_admin = 1;
                $attchObj->is_approved = 1;
                $attchObj->save();

                return sendResponse([], "Content Uploaded Successfully");
            }
            return response()->json(['code' => '302', 'error' => ["File"=>["The File field is required."]]]);

        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
    }

    public function contentRequest(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'id'    => 'required',
                'status' => 'required'
            ]);
            if ($validator->fails()) return response()->json( ['error' => $validator->errors(), 'code'=>'401']); 

            $data = Content::find($request->id);
            $data->is_approved = $request->status;
            $data->save();

            if($request->status == Content::CONTENT_APPROVE){
                $obj = new Reward;
                $obj->user_id = $data->user_id;
                $obj->points = 1;
                $obj->transection_type = Reward::REWARD_CREDIT;
                $obj->reward_type = Reward::CONTENT_REWARD_TYPE;
                $obj->save();
            }
        
            return sendResponse([], 'Status Update Successfully');
            
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }

    }
}
