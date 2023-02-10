<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentCategories;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Http\Request;

class ContentCategoryController extends Controller
{
    public function index(){
        try{
            $categories= ContentCategories::select('id','category_name')->get();
            if(!$categories){
                return sendError('No record Found');
            }
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
        return sendResponse($categories);
    }

    public function getSubject($id)     
    {
        try {
            $category = ContentCategories::find($id);
            if(!$category){
                return sendError('No record found');
            }
        } catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
        return sendResponse($category,200);
    }

    public function addCategory(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                // 'id' => 'required',
                'category_name' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['code' => '302', 'error' => $validator->errors()]);
            }
            $category=new ContentCategories;
            $category->category_name =$request->category_name;
            $category->save();
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
        return sendResponse($category,"Category added successfully");
    }

    public function editCategory($id,Request $request){
        try{
            $validator = Validator::make($request->all(), [
                // 'id' => 'required',
                'category_name' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['code' => '302', 'error' => $validator->errors()]);
            }
            $category=ContentCategories::find($id);
            if(!$category){
                return sendError('No record found');
            }
            $category->category_name = $request->category_name;
            $category->save();
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
        return sendResponse($category,"Category Updated successfully");
    }

    public function destroy($id)    
    {
        try{
            if(!$id){
                return sendError('Id is required');
            }
            $category = ContentCategories::find($id);
            if($category){
                $category->delete();
            }else{
                return sendError('No record found for given Id');
            }
        }catch (Exception $e){
            return response()->json(['status' => 'error', 'code' => '500', 'meassage' => $e->getmessage()]);
        }
        return sendResponse('Deleted Successfully',200);
    }
    
}
