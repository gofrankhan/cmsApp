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
            $data = Customer::select('id','taxid','customertype',DB::raw("concat(firstname,' ', lastname) as fullname"), 'mobile')->orderByDesc('id')->paginate(50);
        }else{
            $data = Customer::select('id','taxid','customertype',DB::raw("concat(firstname,' ', lastname) as fullname"), 'mobile')
                    ->whereIn('user_id', function($query) use ($shop_name){
                        $query->select('id')->from('users')->where('shop_name', $shop_name);
                    })
                    ->orderByDesc('id')
                    ->paginate(50);
        }

        return view('admin.customer_data_table_simple', compact('title', 'data'));
    }

    public function LoadCustomerTableSearch_simple(Request $request)
    {
        $title = "Customer";              
        $shop_name = Auth::user()->shop_name;
        $user_type = Auth::user()->user_type;
        
        $query = Customer::select('id','taxid','customertype',DB::raw("concat(firstname,' ', lastname) as fullname"), 'mobile')
        ->orderByDesc('id');

        $searchTextAny = $request->search_text;
        $searchTextID = $request->search_id;
        $searchTextTaxID = $request->search_tax_id;
        $searchTextName = $request->search_name;
        $searchTextMobileNo = $request->search_mobile_no;

        if(!empty($request->search_text)){
            $query->where(function ($innerQuery) use ($searchText) {
                $innerQuery->where('id', 'like', '%'.$searchText.'%')
            ->orWhere('taxid', 'like', '%'.$searchText.'%')
            ->orWhere('firstname', 'like', '%'.$searchText.'%')
            ->orWhere('lastname', 'like', '%'.$searchText.'%')
            ->orWhere('mobile', 'like', '%'.$searchText.'%')
            ->orWhere('customertype', 'like', '%'.$searchText.'%');
            });
        }

        if(!empty($request->search_id)){
            $query->where(function ($innerQuery) use ($searchTextID) {
                $innerQuery->where('id', 'like', '%'.$searchTextID.'%');
            });
        }
        if(!empty($request->search_tax_id)){
            $query->where(function ($innerQuery) use ($searchTextTaxID) {
                $innerQuery->where('taxid', 'like', '%'.$searchTextTaxID.'%');
            });
        }

        if(!empty($request->search_name)){
            $query->where(function ($innerQuery) use ($searchTextName) {
                $innerQuery->where('firstname', 'like', '%'.$searchTextName.'%')
                ->orWhere('lastname', 'like', '%'.$searchTextName.'%');
            });
        }
        if(!empty($request->search_mobile_no)){
            $query->where(function ($innerQuery) use ($searchTextMobileNo) {
                $innerQuery->where('mobile', 'like', '%'.$searchTextMobileNo.'%');
            });
        }

        if($user_type != 'admin'){
            $query->whereIn('user_id', function($query) use ($shop_name){
                $query->select('id')->from('users')->where('shop_name', $shop_name);
            });
            
        }
        $data = $query->get();
        Debugbar::addMessage($data);
        return response()->json([$data, $user_type]);
    }
}
