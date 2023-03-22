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

class FileController extends Controller
{
    public function FileDataTable(Request $request)
    {
        $title = "Files";
        $shop_name = Auth::user()->shop_name;
        $user_type = Auth::user()->user_type;
        if ($request->ajax()) {
            if($user_type =='admin'){
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
                            <a class="btn btn-outline-secondary btn-sm edit" href="'.route('file.show',$row->file_id).'" target="_blank" title="Show">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a class="btn btn-outline-secondary btn-sm edit" href="'.route('file.edit',$row->file_id).'" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>

                            <a type="submit" class="btn btn-danger btn-sm edit" href="'.route('file.delete' ,$row->id).'" title="Delete">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
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
                                <a class="btn btn-outline-secondary btn-sm edit" href="'.route('file.show',$row->file_id).'" target="_blank" title="Show">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-outline-secondary btn-sm edit" href="'.route('file.edit',$row->file_id).'" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </form>
                            ';
                            return $btn;
                        }
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.file_data_table', compact('title'));
    }

    
    public function MovementDataTable(Request $request)
    {
        $title = "Movement";
        if ($request->ajax()) {
            $data = Invoice::select('invoices.file_id as file_id', 'invoices.description', 'invoices.price as amount', DB::raw("concat(customers.firstname,' ', customers.lastname) as customer"),'services.service')
                                ->leftjoin('customers', 'invoices.customer_id', '=', 'customers.id')
                                ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                                ->where('invoices.status', '=', 'Completed')
                                ->get();
            return Datatables::of($data)
            ->make(true);
        }
        return view('admin.movement_data_table', compact('title'));
    }

    public function FileStore(Request $request)
    {
        $file_id = Invoice::max('file_id');
        $file_id += 1;

        if($request->user != null && !empty($request->user)){
            $shop = User::select('shop_name')->where('username', $request->user)->first();
            $shop_name = $shop->shop_name;
        }else{
            $shop_name = Auth::user()->shop_name;
        }
        console.log($file_id);   
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
            $service_id = Service::select('id', 'price')->where('service', $request->service)->first();
            $file->status = "Submitted";
            if(strtolower($request->category) == 'pagamento'){
                $file->price = -$request->pay_amount;
                $file->service_id = -1;
                $file->description = $request->description;
            }else{
                $file->price = $service_id->price;
                $file->service_id = $service_id->id;
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

    public function UpdateFileStatusAndPrice(Request $request) : RedirectResponse
    {

        $invoice_id = Invoice::select('id')->where('file_id', $request->file_id_no)->first();
        $invoice = Invoice::find($invoice_id->id);
        $invoice->status = $request->file_status;
        $invoice->price = intval($request->pagamento);
        $invoice->save();

        $notification = array(
            'message' => 'Status & Price Updated Successfully', 
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
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
        $files = Invoice::select('invoices.id', 'invoices.price', 'invoices.file_id', 'customers.taxid', 'customers.firstname as customer','invoices.shop_name as shop','services.service', 'invoices.status')
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
        $files = Invoice::select('invoices.id', 'invoices.price', 'invoices.file_id', 'customers.taxid', 'customers.firstname as customer','invoices.shop_name as shop','services.service', 'invoices.status')
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

}
