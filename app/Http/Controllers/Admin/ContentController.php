<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\ContentType;
use App\Models\Reward;
use Carbon\Carbon;
use Exception;
use Form;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Pion\Laravel\ChunkUpload\Exceptions\UploadFailedException;
use Illuminate\Http\UploadedFile;
use countword;
use ZipArchive;
use Illuminate\Support\Facades\File; 
use Smalot\PdfParser\Parser;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        try{
            $keyword = $request->keyword;
            $sort = $request->sort;
            // $uploadBy = $request->uploaded_by_admin;
            $status = $request->status;
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
            // if($uploadBy){
            //     $data = $data->where('contents.uploaded_by_admin','=',$uploadBy);
            // }
            if($status == Content::CONTENT_APPROVE || $status == Content::CONTENT_PENDING ||  $status == Content::CONTENT_DISAPPROVE){
                $data = $data->where('contents.is_approved','=',$status);
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

    public function convertDocToPDF( $docFile){
        
        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF'); 
        $Content = \PhpOffice\PhpWord\IOFactory::load($docFile); 
        $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content,'PDF');
        // dd($PDFWriter); 
        $PDFWriter->save(public_path('new-result.pdf')); 
        echo 'File has been successfully converted';
    }
    
    public function uploade(Request $request)
    {
        try{
            //Turn Off The Throttle API
            //from web route
            // create the file receiver
            $allowedExt = ['pdf','docx','doc'];
            if($request->file('file')){
                
                $user_obj = auth()->user();

                // Check File Extention Validation
                foreach($request->file('file') as $val){
                    $extension =  $val->getClientOriginalExtension();
                    // print_r($extension); echo "<br>";
                    if(!in_array( $extension, $allowedExt )){
                        return sendError('Only PDF, Doc and Docx files are allowed files are allowed');
                    }
                }
                    
                foreach($request->file('file') as $val){
                    $extension =  $val->getClientOriginalExtension();
                    $pageCount = rand(1,10);
                    $wordCount = 0;
                    $description = '';
                    if($extension == 'doc' || $extension == 'docx'){
                        $counter = new countword();
                        $wordCount  = $counter->count($val);
                    }else{
                       // Read Text in PDF File
                        $parser = new Parser();
                        $pdf = $parser->parseFile($val);
                        $text = $pdf->getText();
                        $pageCount = $pdf->getDetails()['Pages'];
                        
                        $description = implode(' ', array_slice(explode(' ', $text), 0, 25))."\n";
                        $text = trim( $text );
                        // // $text = str_replace( " ", "", $text );
                        // Get the word count of file
                        $wordCount = str_word_count( $text);
                    }
                    
                    // print_r( $text);
                    // echo "<br> wordCount=";
                    // print_r( $wordCount);
                    // echo "<br> wordCount2=";
                    // print_r( $wordCount2);
                    // echo "<br>----------------------";

                    if($files=$val){  
                        // $name=$files->getClientOriginalName();
                        // $filename = pathinfo($name, PATHINFO_FILENAME);
                        // $extension = $files->getClientOriginalExtension();
                        // $input = $filename.'_'.time().'.'.$extension;
                        // //$path = $request->file('file')->storeAs('content',$fileName,'public');
                        // $files->move('storage/app/public/content/',$input);
                        // $path = "app/public/content/".$input;  
                        
                        $extension = $val->getClientOriginalExtension();
                        $originalfileName = $val->getClientOriginalName();
                        $originalfileName = pathinfo($originalfileName, PATHINFO_FILENAME);
                        $originalfileName = implode('-',explode(' ', $originalfileName));
                        $fileName = $originalfileName."-".time().'.'.$extension;
                        $path = 'app/public/'.$val->storeAs('content',$fileName,'public');

                        $attchObj = new Content;
                        $attchObj->user_id =$user_obj->id;
                        $attchObj->content_types_id = rand(1,2);
                        $attchObj->name = $fileName;
                        $attchObj->description = $description;
                        $attchObj->content_category = rand(Content::CONTENT_CATEGORY_IT,Content::CONTENT_CATEGORY_NON_IT);
                        $attchObj->path = $path;
                        $attchObj->page_count = $pageCount;
                        $attchObj->word_count = $wordCount;
                        $attchObj->uploaded_by_admin = 1;
                        $attchObj->is_approved = Content::CONTENT_APPROVE;
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

    public function bulkExport(Request $request)
    {
        try {
            $zip      = new ZipArchive;
            $fileName = 'content.zip';
            $fullPath = 'public/'.$fileName;

            //delete Previous Zip file
            if (File::exists($fullPath )) {
                unlink($fullPath );
            }
            $data = Content::get(); 

            if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
                foreach($data as $val){
                    $path =  storage_path($val->path);
                    $relativeName = basename($path);
                    $zip->addFile($path, $relativeName);
                    
                }
                $zip->close();
                
            }
            
            return response()->json(['status' => 'Success', 'code' => 200, 'path' => $fullPath]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'Error', 'code' => 500, 'message' => $th->getMessage()]);
        }
    }
}
