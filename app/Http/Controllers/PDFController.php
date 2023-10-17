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
use App\Models\Pdfdata;
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
         return $pdf->stream('Delega_DSU.pdf');
    }

    public function Delega730_PDF($id)
    {
        $customer = DB::table('customers')->where('id', $id)->first();
  
        $data = [
            'title' => 'Mandato al CAF',
            'date' => date('m/d/Y'),
            'customer' => $customer
        ]; 
            
         $pdf = PDF::loadView('admin.PDF.delega730_PDF', $data);
         return $pdf->stream('Delega_730.pdf');
    }

    public function Autocertificazione_redditi_impresa_pdf($id)
    {
        $ids = Invoice::select('customer_id', 'user_id', 'file_id')->where('id', $id)->first();
        $user = DB::table('users')->where('id', $ids->user_id)->first();
        $customer = DB::table('customers')->where('id', $ids->customer_id)->first();

        $pdfdata['anno'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'anno')->get();
        $pdfdata['rif'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'rif')->get();
        
        $pdfdata['registration_no'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'registration_no')->get();
        $pdfdata['registration_date'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'registration_date')->get();
        $pdfdata['common_chamber_of_commerce'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'common_chamber_of_commerce')->get();
        
        $pdfdata['indirizzo'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo')->get();
        $pdfdata['civico'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'civico')->get();
        $pdfdata['cap'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap')->get();
        $pdfdata['citta'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta')->get();
        $pdfdata['provincia'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia')->get();
        $pdfdata['partita_iva'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'partita_iva')->get();
        $pdfdata['codice_fiscale'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'codice_fiscale')->get();
        $pdfdata['codice_ateco'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'codice_ateco')->get();
        $pdfdata['tipo_attivita'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'tipo_attivita')->get();
        $pdfdata['reddito'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'reddito')->get();

        $data = [
            'title' => 'Mandato al CAF',
            'date' => date('m/d/Y'),
            'customer' => $customer,
            'user' => $user,
            'pdfdata' => $pdfdata
        ]; 
            
         $pdf = PDF::loadView('admin.PDF.Autocertificazione_redditi_impresa_pdf', $data);
         return $pdf->stream('Autocertificazione_redditi_impresa.pdf');
    }

    public function Delega_Trasmissione_Dichiarazione_dei_Redditi_pdf($id)
    {
        $ids = Invoice::select('customer_id', 'user_id', 'file_id')->where('id', $id)->first();
        $user = DB::table('users')->where('id', $ids->user_id)->first();
        $customer = DB::table('customers')->where('id', $ids->customer_id)->first();

        $pdfdata['anno'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'anno')->get();
        $pdfdata['rif'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'rif')->get();
        
        $pdfdata['registration_no'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'registration_no')->get();
        $pdfdata['registration_date'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'registration_date')->get();
        $pdfdata['common_chamber_of_commerce'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'common_chamber_of_commerce')->get();
  
        $data = [
            'title' => 'Mandato al CAF',
            'date' => date('m/d/Y'),
            'customer' => $customer,
            'user' => $user,
            'pdfdata' => $pdfdata
        ]; 
            
         $pdf = PDF::loadView('admin.PDF.Delega_Trasmissione_Dichiarazione_dei_Redditi_pdf', $data);
         return $pdf->stream('Delega_Trasmissione_Dichiarazione_dei_Redditi.pdf');
    }

    public function flussi9($id)
    {
        $ids = Invoice::select('customer_id', 'user_id', 'file_id')->where('id', $id)->first();
        $user = DB::table('users')->where('id', $ids->user_id)->first();
        $customer = DB::table('customers')->where('id', $ids->customer_id)->first();

        $pdfdata['anno'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'anno')->get();
        $pdfdata['rif'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'rif')->get();
        
        $pdfdata['registration_no'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'registration_no')->get();
        $pdfdata['registration_date'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'registration_date')->get();
        $pdfdata['common_chamber_of_commerce'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'common_chamber_of_commerce')->get();
        
        $pdfdata['indirizzo'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo')->get();
        $pdfdata['civico'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'civico')->get();
        $pdfdata['cap'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap')->get();
        $pdfdata['citta'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta')->get();
        $pdfdata['provincia'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia')->get();
        $pdfdata['partita_iva'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'partita_iva')->get();
        $pdfdata['codice_fiscale'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'codice_fiscale')->get();
        $pdfdata['codice_ateco'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'codice_ateco')->get();
        $pdfdata['tipo_attivita'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'tipo_attivita')->get();
        $pdfdata['reddito'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'reddito')->get();

        $data = [
            'title' => 'Mandato al CAF',
            'date' => date('m/d/Y'),
            'customer' => $customer,
            'user' => $user,
            'pdfdata' => $pdfdata
        ]; 
            
         $pdf = PDF::loadView('admin.PDF.flussi9', $data);
         return $pdf->stream('Autocertificazione_redditi_impresa.pdf');
    }

}
