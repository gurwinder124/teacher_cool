<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assignment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Content;

class AssignmentController extends Controller
{
    public function index(Request $request)
    {
        try{
            $keyword = $request->keyword;
            $assignment_status = $request->assignment_status;
            $sort = $request->sort;
            $page_size = ($request->page_size)? $request->page_size : 10;

            
            $data = DB::table('assignments')
                ->leftJoin('users as teacher', 'teacher.id', '=', 'assignments.teacher_id')
                ->leftJoin('users as student', 'student.id', '=', 'assignments.user_id')
                ->select('assignments.*', 'teacher.email as teacher_email','teacher.name as teacher_name',
                'student.email as student_email','student.name as student_name');

            if($keyword && $keyword != ''){
                $data = $data->where(function($query) use ($keyword){
                            $query->where('assignments.title', 'like', '%'.$keyword.'%')
                            ->orWhere('assignments.keyword', 'like', '%'.$keyword.'%');
                        });
            }
            if($assignment_status){
                $data = $data->where('assignments.assignment_status','=', $assignment_status);
            }

            if($sort == 'asc'){
                $data = $data->orderBy('assignments.created_at');
            }else{
                $data = $data->orderByDesc('assignments.created_at');
            }
            $data = $data->paginate($page_size);

            $response = [
                'success' => true,
                'data'    => $data,
                'message' => 'Success',
                'all_assignment_status' => Assignment::assignmentStatus(),
                'category_status' => Content::getContentCategory(),
            ];
        
            return response()->json($response, 200);
            
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
    }

    public function assignmentDetail($id)
    {
        try{
            $data = DB::table('assignments')
                ->leftJoin('users as teacher', 'teacher.id', '=', 'assignments.teacher_id')
                ->leftJoin('users as student', 'student.id', '=', 'assignments.user_id')
                ->select('assignments.*', 'teacher.email as teacher_email','teacher.name as teacher_name',
                'student.email as student_email','student.name as student_name')
                ->where('assignments.id', '=', $id)
                ->first();
            $response = [
                'success' => true,
                'data'    => $data,
                'message' => 'Success',
                'all_assignment_status' => Assignment::assignmentStatus(),
                'category_status' => Content::getContentCategory(),
            ];
            // return sendResponse($data);
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
    }

    public function updateStatus(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'assignment_status' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['code' => '302', 'error' => $validator->errors()]);
            }
            $ids=$request->id;
            if($request->assignment_status != Assignment::ASSIGNMENT_STATUS_APPROVED && $request->assignment_status != Assignment::ASSIGNMENT_STATUS_REJECTED){
                return sendError('Invalid Status Request');
            }
            foreach($ids as $id){
                $assignment = Assignment::find($id);
                if(!$assignment){
                    return sendError('No data found for given Id');
                }
                if($assignment->assignment_status == Assignment::ASSIGNMENT_STATUS_SUBMITTED){
                    $assignment->assignment_status = $request->assignment_status;
                }
                $assignment->save();
            }
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
        return response()->json([
            // 'data'=>$assignment,
            'status' => 200
        ]);

    }
}
