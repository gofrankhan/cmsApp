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
use PDF;

class PDFController extends Controller
{
    //
    public function generatePDF()
    {
        $users = User::get();
  
        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y'),
            'users' => $users
        ]; 
            
        $pdf = PDF::loadView('admin.PDF.myPDF', $data);
     
        return $pdf->download('itsolutionstuff.pdf');
    }

    public function DelegaDSU_PDF($id)
    {
        $customer = DB::table('customers')->where('id', $id)->first();
  
        $data = [
            'title' => 'Mandato al CAF',
            'date' => date('m/d/Y'),
            'customer' => $customer
        ]; 
            
        $pdf = PDF::loadView('admin.PDF.delegaDSU_PDF', $data);
     
        return $pdf->download('Delega_DSU.pdf');
    }
}
