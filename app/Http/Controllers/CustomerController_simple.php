<?php

namespace App\Http\Controllers;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use App\Models\Customer;
use DataTables;
use Debugbar;

class CustomerController_simple extends Controller
{
    public function CustomerDataTable_simple(Request $request)
    {        
        $title = "Customer";              
        $shop_name = Auth::user()->shop_name;
        $user_type = Auth::user()->user_type;
        if($user_type == 'admin'){
            $data = Customer::select('id','taxid','customertype',DB::raw("concat(firstname,' ', lastname) as fullname"), 'mobile')->paginate(50);
        }else{
            $data = Customer::select('id','taxid','customertype',DB::raw("concat(firstname,' ', lastname) as fullname"), 'mobile')
                    ->whereIn('user_id', function($query) use ($shop_name){
                        $query->select('id')->from('users')->where('shop_name', $shop_name);
                    })->paginate(50);
        }

        return view('admin.customer_data_table_simple', compact('title', 'data'));
    }

    public function LoadCustomerTableSearch_simple(Request $request)
    {
        $title = "Customer";              
        $shop_name = Auth::user()->shop_name;
        $user_type = Auth::user()->user_type;
        if($user_type == 'admin'){
            $query = Customer::select('id','taxid','customertype',DB::raw("concat(firstname,' ', lastname) as fullname"), 'mobile')
            ->orderByDesc('id');
        }else{
            $query = Customer::select('id','taxid','customertype',DB::raw("concat(firstname,' ', lastname) as fullname"), 'mobile')
                    ->whereIn('user_id', function($query) use ($shop_name){
                        $query->select('id')->from('users')->where('shop_name', $shop_name);
                    })
                    ->orderByDesc('id');
        }
        if(!empty($request->search_text)){
            $query->where('id', 'like', '%'.$request->search_text.'%')
            ->orWhere('taxid', 'like', '%'.$request->search_text.'%')
            ->orWhere('firstname', 'like', '%'.$request->search_text.'%')
            ->orWhere('lastname', 'like', '%'.$request->search_text.'%')
            ->orWhere('mobile', 'like', '%'.$request->search_text.'%')
            ->orWhere('customertype', 'like', '%'.$request->search_text.'%');
            }
            $data = $query->get();
            Debugbar::addMessage($data);
        return view('admin.customer_data_table_simple', compact('title', 'data'));
    }
}
