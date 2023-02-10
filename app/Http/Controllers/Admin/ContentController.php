<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\ContentCategories;
use App\Models\ContentType;
use App\Models\Reward;
use Carbon\Carbon;
use Exception;
use Form;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Pion\Laravel\ChunkUpload\Exceptions\UploadFailedException;
use Illuminate\Http\UploadedFile;


class ContentController extends Controller
{
    public function index(Request $request)
    {
        try{
            $keyword = $request->keyword;
            $sort = $request->sort;
            $uploadBy = $request->uploaded_by_admin;
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
            if($uploadBy){
                $data = $data->where('contents.uploaded_by_admin','=',$uploadBy);
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

    public function getContent($id)     
    {
        try{
            $data = DB::table('contents')
                    ->leftJoin('users','users.id', '=', 'contents.user_id')
                    ->select('contents.*', 'users.name as teacher_name')
                    ->where('contents.id','=',$id)
                    ->get();
            $response = [
                        'success' => true,
                        'data'    => $data,
                        'message' => 'Success',
                        'content_category' => Content::getContentCategory(),
                        'content_type' => ContentType::select('id','name')->get(),
                        'content_status' => Content::getContentStatus(),
                    ];

        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }

        return sendResponse($response, 200);
    }

    // public function uploade(Request $request)
    // {
    //     try{
    //         $validator = Validator::make($request->all(), [
    //             'content_types_id' => 'required',
    //             'name' => 'required|min:3',
    //             'content_category' => 'required',
    //         ]);

    //         if ($validator->fails()) {
    //             return response()->json(['code' => '302', 'error' => $validator->errors()]);
    //         }

    //         if ($request->file('file')) {
    //             // $name = $request->file('comment_attch')->getClientOriginalName();
    //             $extension = $request->file('file')->getClientOriginalExtension();
    //             $originalfileName = $request->file('file')->getClientOriginalName();
    //             $originalfileName = pathinfo($originalfileName, PATHINFO_FILENAME);
    //             $originalfileName = implode('-',explode(' ', $originalfileName));
    //             $fileName = $originalfileName.'.'.$extension;
    //             $path = $request->file('file')->storeAs('content',$fileName,'public');
                
    //             $attchObj = new Content;
    //             $attchObj->content_types_id = $request->content_types_id;
    //             $attchObj->name =$request->name;
    //             $attchObj->content_category = $request->content_category;
    //             $attchObj->path = $path;
    //             $attchObj->uploaded_by_admin = 1;
    //             $attchObj->is_approved = 1;
    //             $attchObj->save();

    //             return sendResponse([], "Content Uploaded Successfully");
    //         }
    //         return response()->json(['code' => '302', 'error' => ["File"=>["The File field is required."]]]);

    //     }catch (Exception $e){
    //         return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
    //     }
    // }

    public function uploade(Request $request)
    {
        try{
        // dd('here');
        //Turn Off The Throttle API
        //from web route
        // create the file receiver
            if($request->hasFile('file')){
                
                $content_ids =ContentCategories::get('id')->pluck('id');
                // $dd($content_ids);
                $data=new Form;
                $paths=[];
                $user_obj = auth()->user();
                $baseUrl = url('');
                    
                foreach($request->file('file') as $val){
                    if($files=$val){  
                        $name=$files->getClientOriginalName();
                        $filename = pathinfo($name, PATHINFO_FILENAME);
                        $extension = $files->getClientOriginalExtension();
                        $input = $filename.'_'.time().'.'.$extension;
                        //$path = $request->file('file')->storeAs('content',$fileName,'public');
                        $files->move('storage/app/public/content/',$input);
                        $path = $baseUrl."/storage/app/public/content/".$input;  
                        $data->path=$name;  
                        array_push($paths,$path);

                        $attchObj = new Content;
                        $attchObj->user_id =$user_obj->id;
                        $attchObj->content_types_id = array_rand([1,2]);
                        $attchObj->name = $input;
                        $attchObj->content_category = array_rand(is_array($content_ids)?[$content_ids]:[Content::CONTENT_CATEGORY_IT,Content::CONTENT_CATEGORY_NON_IT]);
                        $attchObj->path = $path;
                        $attchObj->uploaded_by_admin = 1;
                        $attchObj->is_approved = 1;
                        $attchObj->save();
                    }        
                } 
                return sendResponse( '', 'File Uploaded Successfully'); 
                    
                }
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
