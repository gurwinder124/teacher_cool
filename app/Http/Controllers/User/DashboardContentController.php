<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\ContentType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardContentController extends Controller
{
    public function index(Request $request)
    {
        try{
            $keyword = $request->keyword;
            $sort = $request->sort;
            $page_size = ($request->page_size)? $request->page_size : 8;

            $data = DB::table('contents as c')->where('c.is_approved','=','1')
                    ->leftJoin('users as u','u.id', '=', 'c.user_id')
                    ->select('c.id','c.content_category','c.name','c.is_approved','c.created_at', 'u.name as teacher_name');
            if($keyword && $keyword != ''){
                $data = $data->where('c.name', 'like', '%'.$keyword.'%');
            }
            if($sort == 'asc'){
                $data = $data->orderBy('c.created_at');
            }else{
                $data = $data->orderByDesc('c.created_at');
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
}
