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
        if ($request->ajax()) {
            $data = Invoice::select('invoices.id as id', 'invoices.file_id as file_id', 'customers.taxid', DB::raw("concat(customers.firstname,' ', customers.lastname) as customer"),'invoices.shop_name as shop','services.service', 'invoices.status')
                                    ->join('customers', 'invoices.customer_id', '=', 'customers.id')
                                    ->join('services', 'invoices.service_id', '=', 'services.id')->get();
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
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.file_data_table', compact('title'));
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
        if(!empty($request->service) && !empty($request->taxid)){
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
            $service_id = Service::select('id')->where('service', $request->service)->first();
            $file->service_id = $service_id->id;
            $file->status = "Submitted";
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
        $files = Invoice::select('invoices.id', 'invoices.file_id', 'customers.taxid', 'customers.firstname as customer','invoices.shop_name as shop','services.service', 'invoices.status')
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
        $files = Invoice::select('invoices.id', 'invoices.file_id', 'customers.taxid', 'customers.firstname as customer','invoices.shop_name as shop','services.service', 'invoices.status')
                                    ->join('customers', 'invoices.customer_id', '=', 'customers.id')
                                    ->join('services', 'invoices.service_id', '=', 'services.id')
                                    ->where('invoices.file_id', $file_id)
                                    ->get();
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
