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
use DataTables;
use Debugbar;

class FileController extends Controller
{
    public function FileDataTable(Request $request, $view_type)
    {
        $title = "Files";
        $shop_name = Auth::user()->shop_name;
        $user_type = Auth::user()->user_type;
        if ($request->ajax()) {
            if($user_type =='admin' && $view_type == 'all'){
                $data = Invoice::select('invoices.id as id', 'invoices.file_id as file_id', 'customers.taxid', DB::raw("concat(customers.firstname,' ', customers.lastname) as customer"),'users.shop_name as shop','services.service', 'invoices.status')
                                    ->leftjoin('customers', 'invoices.customer_id', '=', 'customers.id')
                                    ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                                    ->leftjoin('users', 'invoices.user_id', '=', 'users.id')
                                    ->get();
            }else{
                $data = Invoice::select('invoices.id as id', 'invoices.file_id as file_id', 'customers.taxid', DB::raw("concat(customers.firstname,' ', customers.lastname) as customer"),'users.shop_name as shop','services.service', 'invoices.status')
                                    ->leftjoin('customers', 'invoices.customer_id', '=', 'customers.id')
                                    ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                                    ->leftjoin('users', 'invoices.user_id', '=', 'users.id')
                                    ->whereIn('invoices.user_id', function($query) use ($shop_name){
                                        $query->select('id')->from('users')->where('shop_name', $shop_name);
                                    })->get();
                                }
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $user_type = Auth::user()->user_type;
                    if($user_type == 'admin'){
                        $btn = '
                        <form action="'.route('file.delete',$row->id).'" method="Post">
                            <div class="row">
                            <div class="col-md-4">
                            <a class="btn btn-outline-secondary btn-sm edit" href="'.route('file.show',$row->file_id).'" target="_blank" title="Show">
                                <i class="fas fa-eye"></i>
                            </a>
                            </div>
                            <div class="col-md-4">
                            <a class="btn btn-outline-secondary btn-sm edit" href="'.route('file.edit',$row->file_id).'" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            </div>
                            <div class="col-md-4">
                            <a type="submit" class="btn btn-danger btn-sm edit" href="'.route('file.delete' ,$row->id).'" title="Delete">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                            </div>
                            </div>
                        </form>
                        ';
                        return $btn;
                    }else{
                        if($row->status == 'Completed' || $row->status == 'Cancelled' ){
                            $btn = '
                            <form action="'.route('file.delete',$row->id).'" method="Post">
                                <a class="btn btn-outline-secondary btn-sm edit" href="'.route('file.show',$row->file_id).'" target="_blank" title="Show" >
                                    <i class="fas fa-eye"></i>
                                </a>
                            </form>
                            ';
                            return $btn;
                        }else{
                            $btn = '
                            <form action="'.route('file.delete',$row->id).'" method="Post">
                                <div class="row">
                                <div class="col-md-4">
                                    <a class="btn btn-outline-secondary btn-sm edit" href="'.route('file.show',$row->file_id).'" target="_blank" title="Show">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a class="btn btn-outline-secondary btn-sm edit" href="'.route('file.edit',$row->file_id).'" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </div>
                            </form>
                            ';
                            return $btn;
                        }
                    }
                })
                ->addColumn('icon', function($row){
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
                ->rawColumns(['action', 'icon'])
                ->make(true);
        }
        return view('admin.file_data_table', compact('title'));
    }

    
    public function MovementDataTable(Request $request)
    {
        $title = "Movement";
        $shop_name = Auth::user()->shop_name;
        $user_type = Auth::user()->user_type;
        if ($request->ajax()) {                
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
        $total_sum = Invoice::leftjoin('users', 'invoices.user_id', '=', 'users.id')
                            ->where('invoices.status', '=', 'Completed')
                            ->whereIn('invoices.user_id', function($query) use ($shop_name){
                                $query->select('id')->from('users')->where('shop_name', $shop_name);
                            })->sum('invoices.price');
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

    public function FileStore(Request $request)
    {
        $file_id = Invoice::max('file_id');
        $file_id += 1;
        $user_id = Auth::user()->id;
        if($request->user != null && !empty($request->user)){
            $shop = User::select('id','shop_name')->where('username', $request->user)->first();
            $shop_name = $shop->shop_name;
            $user_id = $shop->id;
        }else{
            $shop_name = Auth::user()->shop_name;
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
            $file->status = "Submitted";
            if(strtolower($request->category) == 'pagamento'){
                $service_id = Service::select('id')->where('category', $request->category)->first();
                $file->service_id = $service_id->id;
                $file->price = -$request->pay_amount;
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
            return redirect()->back()->with($notification);
        }else{
            $notification = array(
                'message' => 'No Service or Tax ID found', 
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

    }

    public function UpdateFileStatusAndPrice(Request $request)
    {

        $invoice_id = Invoice::select('id')->where('file_id', $request->file_id_no)->first();
        $invoice = Invoice::find($invoice_id->id);
        $invoice->status = $request->file_status;
        $invoice->price = intval($request->pagamento);
        $invoice->save();
        
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
        $files = Invoice::select('invoices.id', 'invoices.price', 'invoices.file_id', 'invoices.customer_id', 'customers.taxid', 'customers.firstname as customer','invoices.shop_name as shop','services.service', 'invoices.status')
                                    ->join('customers', 'invoices.customer_id', '=', 'customers.id')
                                    ->join('services', 'invoices.service_id', '=', 'services.id')
                                    ->where('invoices.file_id', $file_id)
                                    ->get();
        return view('admin.file_view', compact('comments', 'attachments', 'files', 'title'));
    }

    public function FileEdit($file_id)
    {
        $title = "Edit File";
        $comments = DB::table('comments')->where('file_id', $file_id)->get();
        $attachments = DB::table('attachments')->where('file_id', $file_id)->get();
        $files = Invoice::select('invoices.id', 'invoices.price', 'invoices.file_id', 'invoices.customer_id', 'customers.taxid', 'customers.firstname as customer','invoices.shop_name as shop','services.service', 'invoices.status')
                                    ->join('customers', 'invoices.customer_id', '=', 'customers.id')
                                    ->join('services', 'invoices.service_id', '=', 'services.id')
                                    ->where('invoices.file_id', $file_id)
                                    ->get();
        $user_type = Auth::user()->user_type;
        if(($files[0]->status == "Completed" || $files[0]->status == "Cancelled") && $user_type != 'admin')
            return redirect()->back();
        return view('admin.file_edit', compact('comments', 'attachments', 'files', 'title'));
    }

      /**
    * Display the specified resource.
    *
    * @param  \App\company  $company
    * @return \Illuminate\Http\Response
    */
    public function FileDelete($id)
    {
        DB::table('invoices')->where('id', $id)->delete();
        $notification = array(
            'message' => 'File deleted successfully', 
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
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

}
