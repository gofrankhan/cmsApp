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
    public function CreateTable(){
        
        $user_count = User::count();
        $shop_count = User::distinct()->count('shop_name');
        $completed_file = Invoice::where('status', '=', 'Completed' )->count();
        $open_file = Invoice::whereIn('status', ['Submitted', 'Pending'] )->count();
        $transactions = Invoice::where('status','=' ,'Completed')->where('price', '>', 0)->sum('price');
        $total_paid = Invoice::where('status','=' ,'Completed')->where('price', '<', 0)->sum('price');

        $card_array = array("user_count"=>$user_count,"shop_count"=>$shop_count, "completed_file"=>$completed_file, "open_file"=>$open_file, "transactions"=>$transactions, 'total_paid'=>$total_paid);

        $totalInvoiceByShop = Invoice::join('users', 'users.id', '=', 'invoices.user_id')
                    ->select(DB::raw('users.shop_name, SUM(invoices.price) as total_invoice, COUNT(invoices.file_id) as count'))
                    ->where('invoices.status', '=', 'Completed')
                    ->groupBy('users.shop_name')
                    ->get();
        return view('admin.index', compact('totalInvoiceByShop', 'card_array'));
    }
}
