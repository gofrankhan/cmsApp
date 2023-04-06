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

class DashboardController extends Controller
{
    public function CreateTable( Request $request){

        if(Auth::user()->user_type != 'admin')
            return view('admin.index');

        if(!empty($request->start_date)){

            $from = $request->start_date;
            $to = $request->end_date;
            $user_count = User::whereBetween('created_at', [$from, $to])->count();
            $shop_count = User::whereBetween('created_at', [$from, $to])->distinct()->count('shop_name');
            $completed_file = Invoice::whereBetween('updated_at', [$from, $to])->where('status', '=', 'Completed' )->count();
            $submit_file = Invoice::whereBetween('created_at', [$from, $to])->where('status', '=', 'Submitted')->count();
            $pending_file = Invoice::whereBetween('updated_at', [$from, $to])->where('status', '=', 'Pending')->count();
            $open_file = $submit_file + $pending_file;
            $transactions = Invoice::whereBetween('updated_at', [$from, $to])->where('status','=' ,'Completed')->where('price', '>', 0)->sum('price');
            $total_paid = Invoice::whereBetween('updated_at', [$from, $to])->where('status','=' ,'Completed')->where('price', '<', 0)->sum('price');
            $daterange = $from.' '.$to;

            $card_array = array("daterange"=>$daterange, "user_count"=>$user_count,"shop_count"=>$shop_count, "completed_file"=>$completed_file, "open_file"=>$open_file, "transactions"=>$transactions, 'total_paid'=>$total_paid);

            $totalInvoiceByShop = Invoice::whereBetween('invoices.updated_at', [$from, $to])
                        ->join('users', 'users.id', '=', 'invoices.user_id')
                        ->select(DB::raw('users.shop_name, 
                                        SUM(invoices.price) as total_invoice, 
                                        SUM(CASE WHEN invoices.price < 0 THEN invoices.price ELSE 0 END) AS negative_sum,
                                        SUM(CASE WHEN invoices.price > 0 THEN invoices.price ELSE 0 END) AS positive_sum,
                                        COUNT(invoices.file_id) as count'))
                        ->where('invoices.status', '=', 'Completed')
                        ->groupBy('users.shop_name')
                        ->get();
        }else{
            $user_count = User::count();
            $shop_count = User::distinct()->count('shop_name');
            $completed_file = Invoice::where('status', '=', 'Completed' )->count();
            $submit_file = Invoice::where('status', '=', 'Submitted')->count();
            $pending_file = Invoice::where('status', '=', 'Pending')->count();
            $open_file = $submit_file + $pending_file;
            $transactions = Invoice::where('status','=' ,'Completed')->where('price', '>', 0)->sum('price');
            $total_paid = Invoice::where('status','=' ,'Completed')->where('price', '<', 0)->sum('price');
            $daterange = '';
            $card_array = array("daterange"=>$daterange, "user_count"=>$user_count,"shop_count"=>$shop_count, "completed_file"=>$completed_file, "open_file"=>$open_file, "transactions"=>$transactions, 'total_paid'=>$total_paid);

            $totalInvoiceByShop = Invoice::join('users', 'users.id', '=', 'invoices.user_id')
                        ->select(DB::raw('users.shop_name, 
                                        SUM(invoices.price) as total_invoice, 
                                        SUM(CASE WHEN invoices.price < 0 THEN invoices.price ELSE 0 END) AS negative_sum,
                                        SUM(CASE WHEN invoices.price > 0 THEN invoices.price ELSE 0 END) AS positive_sum,
                                        COUNT(invoices.file_id) as count'))
                        ->where('invoices.status', '=', 'Completed')
                        ->groupBy('users.shop_name')
                        ->get();
        }
        return view('admin.index', compact('totalInvoiceByShop', 'card_array'));
    }
}
