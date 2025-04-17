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
use PDF;
use DataTables;

class DashboardController extends Controller
{
    public function CreateTable( Request $request){
        $varShowModal = $request->session()->pull('show_modal', false);
        if(Auth::user()->user_type != 'admin')
            return view('admin.index' , compact('varShowModal'));

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
        return view('admin.index', compact('totalInvoiceByShop', 'card_array', 'varShowModal'));
    }

    public function exportCSV()
    {
        ini_set('max_execution_time', 300); // 300 seconds = 5 minutes
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
        $filename = "dashboards.csv";
        $handle = fopen($filename, 'w');

        // Add headers
        fputcsv($handle, [
            'Shop Name',
            'Balance',
            'Due',
            'Transactions',
            'Paid',
            'Count'
        ]);

        // Add rows
        foreach ($totalInvoiceByShop as $invoice) {
            $balance = 0;
            $due = 0;
            if($invoice->total_invoice < 0) { $balance = -$invoice->total_invoice; $due = 0;}
            else { $balance = 0; $due = $invoice->total_invoice;}
            fputcsv($handle, [
                $invoice->shop_name,
                $balance,
                $due,
                $invoice->positive_sum,
                $invoice->negative_sum,
                $invoice->count,
            ]);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend();
    }

    public function exportPDF()
    {
        ini_set('max_execution_time', 300); // 300 seconds = 5 minutes
        ini_set('max_execution_time', 300); // 300 seconds = 5 minutes
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
        $pdf = PDF::loadView('admin.export.dashboard_data', compact('totalInvoiceByShop'))->setPaper('a4')->setOptions([
            'tempDir' => public_path(),
            'chroot' => public_path(),
        ]);
        return $pdf->download('dashboard_data.pdf');
    }
}
