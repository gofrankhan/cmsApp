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
use DataTables;

class FileController extends Controller
{
    public function FileDataTable(Request $request)
    {
        if ($request->ajax()) {
            $data = File::select('id', 'file_id', 'taxid','customer','shop','service', 'status');
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
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
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.file_data_table');
    }

    public function FileStore(Request $request)
    {
        $lastInsertedRow = File::latest()->first();
        $file_id = $lastInsertedRow->file_id + 1;

        $shop_name = Auth::user()->shop_name;
        if(!empty($request->service) && !empty($request->taxid)){
            $file = new File();
            $file->file_id = $file_id;
            $file->taxid = $request->taxid;
            $file->customer = $request->firstname. " ".$request->lastname ;
            $file->shop = $shop_name;
            $file->service = $request->service;
            $file->status = "pending";
            $file->save();
            return $this->FileEdit($file_id);
        }else{
            $notification = array(
                'message' => 'File cannot be created!', 
                'alert-type' => 'alert'
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
        $comments = DB::table('comments')->where('file_id', $file_id)->get();
        $attachments = DB::table('attachments')->where('file_id', $file_id)->get();
        $files = DB::table('files')->where('file_id', $file_id)->get();
        return view('admin.file_view', compact('comments', 'attachments', 'files'));
    }

    public function FileEdit($file_id)
    {
        $comments = DB::table('comments')->where('file_id', $file_id)->get();
        $attachments = DB::table('attachments')->where('file_id', $file_id)->get();
        $files = DB::table('files')->where('file_id', $file_id)->get();
        return view('admin.file_edit', compact('comments', 'attachments', 'files'));
    }

      /**
    * Display the specified resource.
    *
    * @param  \App\company  $company
    * @return \Illuminate\Http\Response
    */
    public function FileDelete($id)
    {
        $customer = DB::table('files')->where('id', $id)->delete();
        $notification = array(
            'message' => 'File deleted successfully', 
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

}
