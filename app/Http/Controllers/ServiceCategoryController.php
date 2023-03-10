<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Comment;
use App\Models\Attachment;
use App\Models\Category;
use App\Models\Service;

class ServiceCategoryController extends Controller
{
    public function CreateCategory(): View
    {
        $title = "Settings";
        $categories = Category::all();
        return view('admin.add_category', compact('categories', 'title'));
    }

    public function AddCategory(Request $request)
    {
        $categories = $request->category;
        if(!empty($categories)){
            foreach($categories as $new_category){
                $category_count = DB::table('categories')->where('category', $new_category)->get()->count();
                if($category_count == 0 && !empty($new_category)){
                    $category = new Category();
                    $category->category = $new_category;
                    $category->save();
                }
            }
            $notification = array(
                'message' => 'Category inserted sucessfully!', 
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

    public function AddService(Request $request)
    {
        $services = $request->service;
        $new_category = $request->new_category;

        if(empty($new_category) && $request->service_category != 'create_new'){
            $new_category = $request->service_category;
        }
        $count = 0;
        foreach($services as $new_service){
            $service_count = DB::table('services')
                                    ->where('category', $new_category)
                                    ->where('service', $new_service)
                                    ->get()
                                    ->count();
            if($service_count == 0 && !empty($new_category) && !empty($new_service) && !empty($request->price[$count])){
                $service = new Service();
                $service->category = $new_category;
                $service->service = $new_service;
                $service->price = $request->price[$count++];
                $service->save();
            }
        }

        $category_count = DB::table('categories')->where('category', $new_category)->get()->count();
        if($category_count == 0 && !empty($new_category)){
            $category = new Category();
            $category->category = $new_category;
            $category->save();
        }

        $notification = array(
            'message' => 'Service category inserted sucessfully!', 
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function AddServiceCategory(Request $request)
    {
        $categories = $request->category;
        $new_service = $request->service;
        if(!empty($categories)){
            foreach($categories as $new_category){
                $service_count = DB::table('services')
                                        ->where('category', $new_category)
                                        ->where('service', $new_service)
                                        ->get()
                                        ->count();
                if($service_count == 0 && !empty($new_category) && !empty($new_service) && !empty($request->price)){
                    $service = new Service();
                    $service->category = $new_category;
                    $service->service = $new_service;
                    $service->price = $request->price;
                    $service->save();
                }
            }
            $notification = array(
                'message' => 'Category inserted sucessfully!', 
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

    public function getServices(Request $request){
        $data = Service::where('category', $request->value)->get();
        return response()->json($data);
    }
}
