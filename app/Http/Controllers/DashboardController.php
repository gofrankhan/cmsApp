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
    public function CardInfo(){
        $user_count = User::all()->count();
        $completed_file = Invoice::where('status', '=', 'Completed' )->count();
        $open_file = Invoice::whereIn('status', ['Submitted', 'Pending'] )->count();

        $list_of_counts = [$user_count, $completed_file, $open_file];
        return response()->json($list_of_counts);
    }
}
