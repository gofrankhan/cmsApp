<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
                        <a class="btn btn-outline-secondary btn-sm edit" href="'.route('file.show',$row->id).'" target="_blank" title="Show">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a class="btn btn-outline-secondary btn-sm edit" href="'.route('file.edit',$row->id).'" title="Edit">
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

    public function FileStore(Request $request): View
    {
        $lastInsertedRow = File::latest()->first();
        $file_id = $lastInsertedRow->id + 10000;

        $shop_name = Auth::user()->shop_name;

        $file = new File();
        $file->file_id = $file_id;
        $file->taxid = $request->taxid;
        $file->customer = $request->firstname. " ".$request->lastname ;
        $file->shop = $shop_name;
        $file->service = $request->service;
        $file->status = "pending";
        $file->save();

        return view('admin.file_data_table');
    }
}
