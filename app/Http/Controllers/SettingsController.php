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
}
