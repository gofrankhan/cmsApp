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
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Pdfdata;
use DataTables;
use Debugbar;


class FileController_simple extends Controller
{
    public function FileDataTable_simple(Request $request, $view_type)
    {
        $title = "Files";
        $shop_name = Auth::user()->shop_name;
        $user_type = Auth::user()->user_type;
        $user_id = Auth::user()->id;
        $data = null;
        if($user_type =='admin'){
            $data = Invoice::select('invoices.id as id', 'invoices.file_id as file_id', 'customers.taxid', DB::raw("concat(customers.firstname,' ', customers.lastname) as customer"),'users.shop_name as shop','services.service', 'invoices.status')
                                ->leftjoin('customers', 'invoices.customer_id', '=', 'customers.id')
                                ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                                ->leftjoin('users', 'invoices.user_id', '=', 'users.id')
                                ->orderByDesc('file_id')
                                ->paginate(50);
        }
        else if ($user_type =='lawyer'){
            $data = Invoice::select('invoices.id as id', 'invoices.file_id as file_id', 'customers.taxid', DB::raw("concat(customers.firstname,' ', customers.lastname) as customer"),'users.shop_name as shop','services.service', 'invoices.status')
                                ->leftjoin('customers', 'invoices.customer_id', '=', 'customers.id')
                                ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                                ->leftjoin('users', 'invoices.user_id', '=', 'users.id')
                                ->where('invoices.user_id', $user_id)
                                ->orderByDesc('file_id')
                                ->paginate(50);
        }
        else {
            $data = Invoice::select('invoices.id as id', 'invoices.file_id as file_id', 'customers.taxid', DB::raw("concat(customers.firstname,' ', customers.lastname) as customer"),'users.shop_name as shop','services.service', 'invoices.status')
                                ->leftjoin('customers', 'invoices.customer_id', '=', 'customers.id')
                                ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                                ->leftjoin('users', 'invoices.user_id', '=', 'users.id')
                                ->whereIn('invoices.user_id', function($query) use ($shop_name){
                                    $query->select('id')->from('users')->where('shop_name', $shop_name);
                                })
                                ->orderByDesc('file_id')
                                ->paginate(50);
        }
        $services = Invoice::select('invoices.service_id as service_id', 'services.service')
                                ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                                ->distinct()
                                ->orderByDesc('file_id')
                                ->get();

        $shops = User::select('shop_name')->distinct()->get();
        return view('admin.file_data_table_simple', compact('data', 'title', 'shops', 'services'));
    }

    public function LoadTableSearch_simple(Request $request)
    {
        $title = "Files";
        $shop_name = Auth::user()->shop_name;
        $user_type = Auth::user()->user_type;
        $user_id = Auth::user()->id;
        $data = null;
        if($user_type =='admin'){
            $query = Invoice::select('invoices.id as id', 'invoices.file_id as file_id', 'customers.taxid', DB::raw("concat(customers.firstname,' ', customers.lastname) as customer"),'users.shop_name as shop','services.service', 'invoices.status')
                                ->leftjoin('customers', 'invoices.customer_id', '=', 'customers.id')
                                ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                                ->leftjoin('users', 'invoices.user_id', '=', 'users.id')
                                ->orderByDesc('file_id');
        }
        else if ($user_type =='user'){
            $query = Invoice::select('invoices.id as id', 'invoices.file_id as file_id', 'customers.taxid', DB::raw("concat(customers.firstname,' ', customers.lastname) as customer"),'users.shop_name as shop','services.service', 'invoices.status')
                                ->leftjoin('customers', 'invoices.customer_id', '=', 'customers.id')
                                ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                                ->leftjoin('users', 'invoices.user_id', '=', 'users.id')
                                ->whereIn('invoices.user_id', function($query_in) use ($shop_name){
                                    $query_in->select('id')->from('users')->where('shop_name', $shop_name);
                                })
                                ->orderByDesc('file_id');
        }
        else if ($user_type =='lawyer'){
            $query = Invoice::select('invoices.id as id', 'invoices.file_id as file_id', 'customers.taxid', DB::raw("concat(customers.firstname,' ', customers.lastname) as customer"),'users.shop_name as shop','services.service', 'invoices.status')
                                ->leftjoin('customers', 'invoices.customer_id', '=', 'customers.id')
                                ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                                ->leftjoin('users', 'invoices.user_id', '=', 'users.id')
                                ->where('invoices.user_id', $user_id)
                                ->orderByDesc('file_id');
        }
        $searchText = $request->search_text;
        if(!empty($request->search_text)){
            $query->where(function ($innerQuery) use ($searchText) {
                $innerQuery->where('file_id', 'like', '%'.$searchText.'%')
            ->orWhere('taxid', 'like', '%'.$searchText.'%')
            ->orWhere('customers.firstname', 'like', '%'.$searchText.'%')
            ->orWhere('customers.lastname', 'like', '%'.$searchText.'%')
            ->orWhere('users.shop_name', 'like', '%'.$searchText.'%')
            ->orWhere('services.service', 'like', '%'.$searchText.'%')
            ->orWhere('status', 'like', '%'.$searchText.'%');
            });
        }
        if(!empty($request->shop_name)) {
            $query->where('users.shop_name', $request->shop_name);
        }
        if(!empty($request->service_type)) {
            $query->where('services.service', $request->service_type);
        }
        if(!empty($request->status)) {
            $query->where('invoices.status', $request->status);
        }
        $data = $query->get();
        Debugbar::addMessage($data);
        return response()->json([$data, $user_type]);
    }

    public function MovementFilterService_simple(Request $request){

        $shop_name = Auth::user()->shop_name;
        $user_type = Auth::user()->user_type;
        $user_id = Auth::user()->id;
        $query = null;
        if($user_type == 'lawyer') {
            $query = Invoice::select('invoices.file_id as file_id', 'invoices.description', 'invoices.lawyer_price as amount', DB::raw("concat(customers.firstname,' ', customers.lastname) as customer"),'services.service')
                            ->leftjoin('customers', 'invoices.customer_id', '=', 'customers.id')
                            ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                            ->leftjoin('users', 'invoices.user_id', '=', 'users.id')
                            ->where('invoices.status', '=', 'Completed')
                            ->where('invoices.lawyer_id', $user_id)
                            ->orderByDesc('file_id');
            
        } else if (!$request->all_data){
            $query = Invoice::select('invoices.file_id as file_id', 'invoices.description', 'invoices.price as amount', DB::raw("concat(customers.firstname,' ', customers.lastname) as customer"),'services.service')
                            ->leftjoin('customers', 'invoices.customer_id', '=', 'customers.id')
                            ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                            ->leftjoin('users', 'invoices.user_id', '=', 'users.id')
                            ->where('invoices.status', '=', 'Completed')
                            ->whereIn('invoices.user_id', function($query) use ($shop_name){
                                $query->select('id')->from('users')->where('shop_name', $shop_name);
                            })
                            ->orderByDesc('file_id');
        }else if($request->all_data){
            $query = Invoice::select('invoices.file_id as file_id', 'invoices.description', 'invoices.price as amount', DB::raw("concat(customers.firstname,' ', customers.lastname) as customer"),'services.service')
                            ->leftjoin('customers', 'invoices.customer_id', '=', 'customers.id')
                            ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                            ->leftjoin('users', 'invoices.user_id', '=', 'users.id')
                            ->where('invoices.status', '=', 'Completed')
                            ->orderByDesc('file_id');
        }

        if(!empty($request->service_type)) {
            $query->where('services.service', $request->service_type);
        }

        $data = $query->get();
        Debugbar::addMessage($data);
        return response()->json($data);
    }

    public function FileDataTable(Request $request, $view_type)
    {
        $title = "Files";
        $shop_name = Auth::user()->shop_name;
        $user_type = Auth::user()->user_type;
        $user_id = Auth::user()->id;
        if ($request->ajax()) {
            if($user_type =='admin' && $view_type == 'all'){
                $data = DB::table('invoices')
                                    ->leftjoin('customers', 'invoices.customer_id', '=', 'customers.id')
                                    ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                                    ->leftjoin('users', 'invoices.user_id', '=', 'users.id')
                                    ->select('invoices.id as id', 'invoices.file_id as file_id', 'customers.taxid', 
                                    DB::raw("concat(customers.firstname,' ', customers.lastname) as customer"),
                                    'users.shop_name as shop','services.service', 'invoices.status', 'invoices.lawyer_id', 'invoices.lawyer_price')
                                    ->get();
            }
            else if ($user_type =='user'){
                $data = DB::table('invoices')
                                    ->leftjoin('customers', 'invoices.customer_id', '=', 'customers.id')
                                    ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                                    ->leftjoin('users', 'invoices.user_id', '=', 'users.id')
                                    ->whereIn('invoices.user_id', function($query) use ($shop_name){
                                        $query->select('id')->from('users')->where('shop_name', $shop_name);
                                    })
                                    ->select('invoices.id as id', 'invoices.file_id as file_id', 'customers.taxid', 
                                        DB::raw("concat(customers.firstname,' ', customers.lastname) as customer"),
                                        'users.shop_name as shop','services.service', 'invoices.status')
                                    ->get();
            }
            else if ($user_type =='lawyer'){
                $data = DB::table('invoices')
                                    ->leftjoin('customers', 'invoices.customer_id', '=', 'customers.id')
                                    ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                                    ->leftjoin('users', 'invoices.user_id', '=', 'users.id')
                                    ->where('invoices.lawyer_id', '=', $user_id)
                                    ->select('invoices.id as id', 'invoices.file_id as file_id', 'customers.taxid', 
                                        DB::raw("concat(customers.firstname,' ', customers.lastname) as customer"),
                                        'users.shop_name as shop','services.service', 'invoices.status', 'invoices.lawyer_id', 'invoices.lawyer_price')
                                    ->get();
            }
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $user_type = Auth::user()->user_type;
                    if($user_type == 'admin'){
                        $btn = '
                        <div style="width:150px" class="row">
                        <form>
                            <a class="btn btn-outline-secondary btn-sm edit" href="'.route('file.show',$row->file_id).'" target="_blank" title="Show">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a class="btn btn-outline-secondary btn-sm edit" href="'.route('file.edit',$row->file_id).'"target="_blank" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a type="submit" class="btn btn-danger btn-sm edit" data-id="'. $row->id.'" title="Delete">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </form>
                        </div>';
                        return $btn;
                    }else{
                        if($row->status == 'Completed' || $row->status == 'Cancelled' ){
                            $btn = '
                            <a class="btn btn-outline-secondary btn-sm edit" href="'.route('file.show',$row->file_id).'" target="_blank" title="Show">
                                <i class="fas fa-eye"></i>
                            </a>
                            ';
                            return $btn;
                        }else{
                            $btn = '
                            <a class="btn btn-outline-secondary btn-sm edit" href="'.route('file.show',$row->file_id).'" target="_blank" title="Show">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a class="btn btn-outline-secondary btn-sm edit" href="'.route('file.edit',$row->file_id).'" target="_blank" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            ';
                            return $btn;
                        }
                    }
                })
                ->addColumn('icon', function($row){
                    $btn = "";
                    if($row->status == "Completed")
                        $btn = '<div class="font-size-13"><i class="ri-checkbox-blank-circle-fill font-size-10 text-success align-middle me-2"></i></div>';
                    else if($row->status == "Pending") 
                        $btn = '<div class="font-size-13"><i class="ri-checkbox-blank-circle-fill font-size-10 text-warning align-middle me-2"></i></div>';
                    else if($row->status == "Submitted")
                        $btn = '<div class="font-size-13"><i class="ri-checkbox-blank-circle-fill font-size-10 text-dark align-middle me-2"></i></div>';
                    else if($row->status == "Cancelled")
                        $btn = '<div class="font-size-13"><i class="ri-checkbox-blank-circle-fill font-size-10 text-danger align-middle me-2"></i></div>';
                    return $btn;
                })
                ->addColumn('id', function($row){
                    $btn = '<label style="display:none">$row->id</label>';
                    return $btn;
                })
                ->rawColumns(['action', 'icon', 'id'])
                ->make(true);
        }
        
        return view('admin.file_data_table_simple', compact('title'));
    }

    
    public function MovementDataTable(Request $request)
    {
        $title = "Movement";
        $shop_name = Auth::user()->shop_name;
        $user_type = Auth::user()->user_type;
        $user_id = Auth::user()->id;
        if ($request->ajax()) {    
            if($user_type == 'lawyer') {
                $data = Invoice::select('invoices.file_id as file_id', 'invoices.description', 'invoices.lawyer_price as amount', DB::raw("concat(customers.firstname,' ', customers.lastname) as customer"),'services.service')
                                ->leftjoin('customers', 'invoices.customer_id', '=', 'customers.id')
                                ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                                ->leftjoin('users', 'invoices.user_id', '=', 'users.id')
                                ->where('invoices.status', '=', 'Completed')
                                ->where('invoices.lawyer_id', $user_id)
                                ->get();
                    return Datatables::of($data)
                    ->make(true);
                
            } else{
                $data = Invoice::select('invoices.file_id as file_id', 'invoices.description', 'invoices.price as amount', DB::raw("concat(customers.firstname,' ', customers.lastname) as customer"),'services.service')
                                ->leftjoin('customers', 'invoices.customer_id', '=', 'customers.id')
                                ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                                ->leftjoin('users', 'invoices.user_id', '=', 'users.id')
                                ->where('invoices.status', '=', 'Completed')
                                ->whereIn('invoices.user_id', function($query) use ($shop_name){
                                    $query->select('id')->from('users')->where('shop_name', $shop_name);
                                })->get();
                    return Datatables::of($data)
                    ->make(true);
            }       
            
        }

        if($user_type == 'lawyer') {
            $total_sum = Invoice::leftjoin('users', 'invoices.lawyer_id', '=', 'users.id')
                        ->where('invoices.status', '=', 'Completed')
                        ->where('invoices.lawyer_id', $user_id)
                        ->sum('invoices.lawyer_price');
        } else {
            $total_sum = Invoice::leftjoin('users', 'invoices.user_id', '=', 'users.id')
                ->where('invoices.status', '=', 'Completed')
                ->whereIn('invoices.user_id', function($query) use ($shop_name){
                    $query->select('id')->from('users')->where('shop_name', $shop_name);
                })->sum('invoices.price');
        }

        return view('admin.movement_data_table', compact('title', 'total_sum'));
    }

    public function MovementDataTableAll(Request $request)
    {
        $title = "Movement";
        $shop_name = Auth::user()->shop_name;
        $user_type = Auth::user()->user_type;
        if ($request->ajax()) {
            if($user_type =='admin'){
                $data = Invoice::select('invoices.file_id as file_id', 'invoices.description', 'invoices.price as amount', DB::raw("concat(customers.firstname,' ', customers.lastname) as customer"),'services.service')
                                    ->leftjoin('customers', 'invoices.customer_id', '=', 'customers.id')
                                    ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                                    ->where('invoices.status', '=', 'Completed')
                                    ->get();
            }
            return Datatables::of($data)
            ->make(true);
        }
        return view('admin.movement_data_table_all', compact('title'));
    }

    public function MovementDataTable_simple(Request $request)
    {
        $title = "Movement";
        $shop_name = Auth::user()->shop_name;
        $user_type = Auth::user()->user_type;
        $user_id = Auth::user()->id;  
        $data = null;
        if($user_type == 'lawyer') {
            $data = Invoice::select('invoices.file_id as file_id', 'invoices.description', 'invoices.lawyer_price as amount', DB::raw("concat(customers.firstname,' ', customers.lastname) as customer"),'services.service')
                            ->leftjoin('customers', 'invoices.customer_id', '=', 'customers.id')
                            ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                            ->leftjoin('users', 'invoices.user_id', '=', 'users.id')
                            ->where('invoices.status', '=', 'Completed')
                            ->where('invoices.lawyer_id', $user_id)
                            ->orderByDesc('file_id')
                            ->paginate(50);
            
        } else{
            $data = Invoice::select('invoices.file_id as file_id', 'invoices.description', 'invoices.price as amount', DB::raw("concat(customers.firstname,' ', customers.lastname) as customer"),'services.service')
                            ->leftjoin('customers', 'invoices.customer_id', '=', 'customers.id')
                            ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                            ->leftjoin('users', 'invoices.user_id', '=', 'users.id')
                            ->where('invoices.status', '=', 'Completed')
                            ->whereIn('invoices.user_id', function($query) use ($shop_name){
                                $query->select('id')->from('users')->where('shop_name', $shop_name);
                            })
                            ->orderByDesc('file_id')
                            ->paginate(50);
        }       
            
        if($user_type == 'lawyer') {
            $total_sum = Invoice::leftjoin('users', 'invoices.lawyer_id', '=', 'users.id')
                        ->where('invoices.status', '=', 'Completed')
                        ->where('invoices.lawyer_id', $user_id)
                        ->sum('invoices.lawyer_price');
        } else {
            $total_sum = Invoice::leftjoin('users', 'invoices.user_id', '=', 'users.id')
                ->where('invoices.status', '=', 'Completed')
                ->whereIn('invoices.user_id', function($query) use ($shop_name){
                    $query->select('id')->from('users')->where('shop_name', $shop_name);
                })->sum('invoices.price');
        }

        $services = Invoice::select('invoices.service_id as service_id', 'services.service')
                                ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                                ->where('invoices.status', '=', 'Completed')
                                ->whereIn('invoices.user_id', function($query) use ($shop_name){
                                    $query->select('id')->from('users')->where('shop_name', $shop_name);
                                })
                                ->distinct()
                                ->orderByDesc('file_id')
                                ->get();

        return view('admin.movement_data_table_simple', compact('title', 'total_sum', 'data', 'services'));
    }

    public function MovementDataTableAll_simple(Request $request)
    {
        $title = "Movement";
        $shop_name = Auth::user()->shop_name;
        $user_type = Auth::user()->user_type;
        if($user_type =='admin'){
            $data = Invoice::select('invoices.file_id as file_id', 'invoices.description', 'invoices.price as amount', DB::raw("concat(customers.firstname,' ', customers.lastname) as customer"),'services.service')
                                ->leftjoin('customers', 'invoices.customer_id', '=', 'customers.id')
                                ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                                ->where('invoices.status', '=', 'Completed')
                                ->orderByDesc('file_id')
                                ->paginate(50);
        }
        $services = Invoice::select('invoices.service_id as service_id', 'services.service')
                                ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                                ->where('invoices.status', '=', 'Completed')
                                ->distinct()
                                ->orderByDesc('file_id')
                                ->get();
        return view('admin.movement_data_table_all_simple', compact('title', 'data', 'services'));
    }

    public function FileStore(Request $request)
    {
        $file_id = Invoice::max('file_id');
        $file_id += 1;
        $user_id = Auth::user()->id;
        $user_type = Auth::user()->user_type;
        $shop_name = Auth::user()->shop_name;
        $lawyer_id = null;
        if($user_type == 'lawyer')
            $lawyer_id = $user_id;
        
        if($request->user != null && !empty($request->user)){
            $user_info = User::select('id','shop_name', 'user_type')->where('username', $request->user)->first();
            if($user_type == 'lawyer'){
                $lawyer_id = $user_id;
                $shop_name = $user_info->shop_name;
                $user_id = $user_info->id;
            }else{
                $user_type_1 = $user_info->user_type;
                if($user_type_1 == 'lawyer')
                    $lawyer_id = $user_info->id;
                $shop_name = $user_info->shop_name;
                $user_id = $user_info->id;
            }
        }
        if((!empty($request->service) || strtolower($request->category) == 'pagamento') && !empty($request->taxid)){
            $file = new Invoice();
            $file->file_id = $file_id;
            $customer_id = Customer::select('id')->where('taxid', $request->taxid)->first();
            if($customer_id == null){
                $notification = array(
                    'message' => 'Tax ID not found!', 
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }
            $file->customer_id = $customer_id->id;
            $file->shop_name = $shop_name;
            $file->user_id = $user_id;
            $file->lawyer_id = $lawyer_id;
            
            $file->status = "Submitted";
            if(strtolower($request->category) == 'pagamento'){
                $service_id = Service::select('id')->where('category', $request->category)->first();
                $file->service_id = $service_id->id;
                $file->price = -$request->pay_amount;
                $file->lawyer_price = -$request->pay_amount;
                $file->description = $request->description;
            }else{
                $service_id = Service::select('id', 'price')->where('service', $request->service)->first();
                $file->service_id = $service_id->id;
                $file->price = $service_id->price;
            }
            $file->save();
            $notification = array(
                'message' => 'File created successfully!', 
                'alert-type' => 'success'
            );
            return response()->json(['success' => true]);
        }else{
            $notification = array(
                'message' => 'No Service or Tax ID found', 
                'alert-type' => 'error'
            );
            return response()->json(['error' => true]);
        }

    }

    public function UpdateService(Request $request){
        $invoice_id = Invoice::select('id')->where('file_id', $request->file_id_no)->first();
        $invoice = Invoice::find($invoice_id->id);
        $service_id = Service::select('id')->where('service', $request->service2)->first();
        $invoice->service_id = intval($service_id->id);
        $invoice->save();
        return redirect()->back();
    }

    public function UpdateFileStatusAndPrice(Request $request)
    {

        $invoice_id = Invoice::select('id')->where('file_id', $request->file_id_no)->first();
        $invoice = Invoice::find($invoice_id->id);
        $invoice->status = $request->file_status;
        $invoice->price = intval($request->pagamento);
        $invoice->lawyer_price = intval($request->pagamento_lawyer);
        $invoice->save();
        
        if($request->anno != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'anno');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'anno')
                        ->update(['field_value' => $request->anno]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "anno";
                $pdfdata->field_value= $request->anno;
                $pdfdata->save();
            }
        }
        if($request->rif != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'rif');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'rif')
                        ->update(['field_value' => $request->rif]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "rif";
                $pdfdata->field_value= $request->rif;
                $pdfdata->save();
            }
        }
        if($request->registration_no != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'registration_no');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'registration_no')
                        ->update(['field_value' => $request->registration_no]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "registration_no";
                $pdfdata->field_value= $request->registration_no;
                $pdfdata->save();
            }
        }
        if($request->registration_date != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'registration_date');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'registration_date')
                        ->update(['field_value' => $request->registration_date]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "registration_date";
                $pdfdata->field_value= $request->registration_date;
                $pdfdata->save();
            }
        }
        if($request->common_chamber_of_commerce != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'common_chamber_of_commerce');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'common_chamber_of_commerce')
                        ->update(['field_value' => $request->common_chamber_of_commerce]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "common_chamber_of_commerce";
                $pdfdata->field_value= $request->common_chamber_of_commerce;
                $pdfdata->save();
            }
        }
        if($request->indirizzo != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'indirizzo');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'indirizzo')
                        ->update(['field_value' => $request->indirizzo]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "indirizzo";
                $pdfdata->field_value= $request->indirizzo;
                $pdfdata->save();
            }
        }
        if($request->civico != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'civico');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'civico')
                        ->update(['field_value' => $request->civico]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "civico";
                $pdfdata->field_value= $request->civico;
                $pdfdata->save();
            }
        }
        if($request->cap != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'cap');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'cap')
                        ->update(['field_value' => $request->cap]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "cap";
                $pdfdata->field_value= $request->cap;
                $pdfdata->save();
            }
        }
        if($request->citta != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'citta');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'citta')
                        ->update(['field_value' => $request->citta]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "citta";
                $pdfdata->field_value= $request->citta;
                $pdfdata->save();
            }
        }
        if($request->provincia != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'provincia');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'provincia')
                        ->update(['field_value' => $request->provincia]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "provincia";
                $pdfdata->field_value= $request->provincia;
                $pdfdata->save();
            }
        }
        if($request->partita_iva != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'partita_iva');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'partita_iva')
                        ->update(['field_value' => $request->partita_iva]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "partita_iva";
                $pdfdata->field_value= $request->partita_iva;
                $pdfdata->save();
            }
        }
        if($request->codice_fiscale != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'codice_fiscale');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'codice_fiscale')
                        ->update(['field_value' => $request->codice_fiscale]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "codice_fiscale";
                $pdfdata->field_value= $request->codice_fiscale;
                $pdfdata->save();
            }
        }
        if($request->codice_ateco != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'codice_ateco');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'codice_ateco')
                        ->update(['field_value' => $request->codice_ateco]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "codice_ateco";
                $pdfdata->field_value= $request->codice_ateco;
                $pdfdata->save();
            }
        }
        if($request->tipo_attivita != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'tipo_attivita');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'tipo_attivita')
                        ->update(['field_value' => $request->tipo_attivita]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "tipo_attivita";
                $pdfdata->field_value= $request->tipo_attivita;
                $pdfdata->save();
            }
        }
        if($request->reddito != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'reddito');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'reddito')
                        ->update(['field_value' => $request->reddito]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "reddito";
                $pdfdata->field_value= $request->reddito;
                $pdfdata->save();
            }
        }
        return redirect()->back();
    }

    public function CommentAttachment($file_id): View
    {
        $comments = DB::table('comments')->where('file_id', $file_id)->get();
        $attachments = DB::table('attachments')->where('file_id', $file_id)->get();
        $files = DB::table('files')->where('file_id', $file_id)->get();
        return view('admin.file_view', compact('comments', 'attachments', 'files'));
    }

    public function FileShow($file_id): View
    {
        $title = "Show File";
        $comments = DB::table('comments')->where('file_id', $file_id)->get();
        $attachments = DB::table('attachments')->where('file_id', $file_id)->get();
        $files = Invoice::select('invoices.id', 'invoices.price', 'invoices.file_id', 'invoices.customer_id', 
                                'customers.taxid', 'customers.firstname as customer','invoices.shop_name as shop',
                                'services.service', 'invoices.status', 'invoices.lawyer_id', 'invoices.lawyer_price')
                                    ->join('customers', 'invoices.customer_id', '=', 'customers.id')
                                    ->join('services', 'invoices.service_id', '=', 'services.id')
                                    ->where('invoices.file_id', $file_id)
                                    ->get();
        $pdfdata['anno'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'anno')->get();
        $pdfdata['rif'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'rif')->get();
        $pdfdata['registration_no'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'registration_no')->get();
        $pdfdata['registration_date'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'registration_date')->get();
        $pdfdata['common_chamber_of_commerce'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'common_chamber_of_commerce')->get();
        $pdfdata['indirizzo'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'indirizzo')->get();
        $pdfdata['civico'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'civico')->get();
        $pdfdata['cap'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'cap')->get();
        $pdfdata['citta'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'citta')->get();
        $pdfdata['provincia'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'provincia')->get();
        $pdfdata['partita_iva'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'partita_iva')->get();
        $pdfdata['codice_fiscale'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'codice_fiscale')->get();
        $pdfdata['codice_ateco'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'codice_ateco')->get();
        $pdfdata['tipo_attivita'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'tipo_attivita')->get();
        $pdfdata['reddito'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'reddito')->get();
        return view('admin.file_view', compact('comments', 'attachments', 'files', 'pdfdata', 'title'));
    }

    public function FileEdit($file_id)
    {
        $title = "Edit File";
        $comments = DB::table('comments')->where('file_id', $file_id)->get();
        $attachments = DB::table('attachments')->where('file_id', $file_id)->get();
        $files = Invoice::select('invoices.id', 'invoices.price', 'invoices.file_id', 'invoices.customer_id', 
                                'customers.taxid', 'customers.firstname as customer','invoices.shop_name as shop',
                                'services.service', 'invoices.status', 'invoices.lawyer_id', 'invoices.lawyer_price')
                                    ->join('customers', 'invoices.customer_id', '=', 'customers.id')
                                    ->join('services', 'invoices.service_id', '=', 'services.id')
                                    ->where('invoices.file_id', $file_id)
                                    ->get();
        $pdfdata['anno'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'anno')->get();
        $pdfdata['rif'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'rif')->get();
        $pdfdata['registration_no'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'registration_no')->get();
        $pdfdata['registration_date'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'registration_date')->get();
        $pdfdata['common_chamber_of_commerce'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'common_chamber_of_commerce')->get();
        $pdfdata['indirizzo'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'indirizzo')->get();
        $pdfdata['civico'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'civico')->get();
        $pdfdata['cap'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'cap')->get();
        $pdfdata['citta'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'citta')->get();
        $pdfdata['provincia'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'provincia')->get();
        $pdfdata['partita_iva'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'partita_iva')->get();
        $pdfdata['codice_fiscale'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'codice_fiscale')->get();
        $pdfdata['codice_ateco'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'codice_ateco')->get();
        $pdfdata['tipo_attivita'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'tipo_attivita')->get();
        $pdfdata['reddito'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'reddito')->get();
        $user_type = Auth::user()->user_type;
        if(($files[0]->status == "Completed" || $files[0]->status == "Cancelled") && $user_type != 'admin')
            return redirect()->back();
        return view('admin.file_edit', compact('comments', 'attachments', 'files', 'pdfdata' , 'title'));
    }

      /**
    * Display the specified resource.
    *
    * @param  \App\company  $company
    * @return \Illuminate\Http\Response
    */
    public function FileDelete($file_id)
    {
        DB::table('invoices')->where('file_id', $file_id)->delete();
        $notification = array(
            'message' => 'File deleted successfully', 
            'alert-type' => 'success'
        );
        //return redirect()->back()->with($notification);
        return response()->json();
    }

    public function AssignFiles(Request $request){

        $fileids = preg_replace('/\s+/', '', $request->fileids);
        $fileidsArray = explode(',', $fileids);
        $isAllNumeric = true;
        foreach($fileidsArray as $fileid){
            if(!is_numeric($fileid)){
                $isAllNumeric = false;
            }
        }
        if($isAllNumeric){
            $user_type = User::select('user_type')->where('id', $request->assign_user_id)->first();
            if($user_type->user_type == 'lawyer')
                DB::table('invoices')->whereIn('file_id', $fileidsArray)->update(['lawyer_id' => (int)$request->assign_user_id]);
            else
                DB::table('invoices')->whereIn('file_id', $fileidsArray)->update(['user_id' => (int)$request->assign_user_id]);
            $notification = array(
                'message' => 'File assigned successfully', 
                'alert-type' => 'success'
            );
        }else{
            $notification = array(
                'message' => 'Some file id is not a number', 
                'alert-type' => 'error'
            );
        }
        return redirect()->back()->with($notification);
    }

    public function GetShopNameList(Request $request){
        $data = User::select('shop_name')->distinct()->get();
        return response()->json($data);
    }

    public function GetServiceTypeList(Request $request){
        $data = Service::select('service')->distinct()->get();
        return response()->json($data);
    }

}
