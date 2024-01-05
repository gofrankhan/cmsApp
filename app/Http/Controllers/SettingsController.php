<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\User;
use App\Models\File;
use App\Models\UploadType;
use App\Models\Category;
use App\Models\Service;
use App\Models\PdfFile;
use DataTables;

class SettingsController extends Controller
{
    public function CreateSettings(): View
    {
        $title = "Settings";
        $categories = Category::all();
        return view('admin.add_settings', compact('categories','title'));
    }

    public function AddUploadType(Request $request)
    {
        $upload_types = $request->upload_type;
        if(!empty($upload_types)){
            foreach($upload_types as $upload_type){
                $upload_type_count = DB::table('upload_types')->where('upload_type', $upload_type)->get()->count();
                if($upload_type_count == 0 && !empty($upload_type)){
                    $upload_type_model = new UploadType();
                    $upload_type_model->upload_type = $upload_type;
                    $upload_type_model->save();
                }
            }
            $notification = array(
                'message' => 'Upload type inserted sucessfully!', 
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }else{
            $notification = array(
                'message' => 'No data inserted!', 
                'alert-type' => 'warning'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function UploadPDFFile(Request $request)
    {
        $pdf_file_name = $request->pdf_file_name;
        $pdf_category = $request->pdf_category;
        $pdf_service = $request->pdf_service;

        if(!empty($pdf_file_name) && !empty($pdf_category)){

            if ($request->file('upload_pdf_file')) {
                $file = $request->file('upload_pdf_file');
     
                $filename = $file->getClientOriginalName();
                $filename = str_replace(' ', '_', $filename);
                $full_path = 'upload/static_pdf';
                if(!is_dir($full_path))
                    mkdir($full_path, 0755);
                if(file_exists($full_path.'/'.$filename)){
                    $notification = array(
                        'message' => 'File already exists!', 
                        'alert-type' => 'warning'
                    );
                    return redirect()->back()->with($notification);
                }
                $file->move($full_path ,$filename);
                $pdf_file = new PdfFile();
                $pdf_file->pdf_file_name = $pdf_file_name;
                $pdf_file->category = $pdf_category;
                $pdf_file->service = $pdf_service;
                $pdf_file['upload_pdf_file'] = $filename;
                $pdf_file->save();
                $notification = array(
                    'message' => 'New statif pdf file added successfully', 
                    'alert-type' => 'success'
                );
             }else{
                $notification = array(
                    'message' => 'No file added!', 
                    'alert-type' => 'info'
                );
             }
            return redirect()->back()->with($notification);
        }else{
            $notification = array(
                'message' => 'Must enter PDF file name or category!', 
                'alert-type' => 'warning'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function StaticPDFFile(){
        {
            $title = "Static PDF Files";
            $pdf_files = DB::table('pdf_files')->get();
            $categories = Category::all();
            return view('admin.static_pdf_file', compact('pdf_files', 'categories', 'title'));
        }
    }

    public function DeletePDFFile($id){
        $file_info = DB::table('pdf_files')->where('id', $id)->get();
        $files = DB::table('pdf_files')
                        ->where('id', $id)
                        ->delete();
        dd('$file_info->upload_pdf_file)');
        $file = ('upload/static_pdf/'.$file_info->upload_pdf_file);
        $realPath = realpath($file);
        if ($realPath) {
            File::delete($realPath);
            $notification = array(
                'message' => 'File deleted successfully!', 
                'alert-type' => 'success'
             );
        } else {
            $notification = array(
                'message' => 'File doesnot exist of incorrect path!', 
                'alert-type' => 'warning'
             );
        }
        return redirect()->back()->with($notification);
    }
}
