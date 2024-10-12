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
use App\Models\PdfFile;
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

    public function Delega_INPS($id)
    {
        $customer = DB::table('customers')->where('id', $id)->first();
  
        $data = [
            'title' => 'Mandato al CAF',
            'date' => date('m/d/Y'),
            'customer' => $customer
        ]; 
            
         $pdf = PDF::loadView('admin.PDF.delega_inps', $data);
         return $pdf->stream('delega_inps.pdf');
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

        $pdfdata['nome'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'nome')->get();
        $pdfdata['cognome'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cognome')->get();
        $pdfdata['luogo_nascita'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'luogo_nascita')->get();
        $pdfdata['data_nascita'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'data_nascita')->get();
        $pdfdata['sesso'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'sesso')->get();
        $pdfdata['cittadinanza'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cittadinanza')->get();
        $pdfdata['paese_residenza'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'paese_residenza')->get();
        $pdfdata['ragione_sociale'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'ragione_sociale')->get();
        $pdfdata['cf_azienda'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cf_azienda')->get();
        $pdfdata['flussi_partita_iva'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'flussi_partita_iva')->get();
        $pdfdata['indirizzo_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_sede')->get();
        $pdfdata['citta_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_sede')->get();
        $pdfdata['provincia_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_sede')->get();
        $pdfdata['cap_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_sede')->get();
        $pdfdata['indirizzo_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_operativa')->get();
        $pdfdata['citta_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_operativa')->get();
        $pdfdata['provincia_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_operativa')->get();
        $pdfdata['cap_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_operativa')->get();
        $pdfdata['matricola_inps'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'matricola_inps')->get();
        $pdfdata['sede_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'sede_inail')->get();
        $pdfdata['codice_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'codice_inail')->get();
        $pdfdata['controllo_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'controllo_inail')->get();
        $pdfdata['provincia_cciaa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_cciaa')->get();
        $pdfdata['numero_cciaa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'numero_cciaa')->get();
        $pdfdata['data_iscrizione'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'data_iscrizione')->get();
        $pdfdata['numero_dipendenti'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'numero_dipendenti')->get();
        $pdfdata['codice_sdi'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'codice_sdi')->get();
        $pdfdata['fatturato_annoprima'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'fatturato_annoprima')->get();
        $pdfdata['redditi_annoprima'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'redditi_annoprima')->get();
        $pdfdata['tipologia_contratto'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'tipologia_contratto')->get();
        $pdfdata['tempo'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'tempo')->get();
        $pdfdata['mansoine'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'mansoine')->get();
        $pdfdata['mesi_lavoro'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'mesi_lavoro')->get();
        $pdfdata['orario_settimanale'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'orario_settimanale')->get();
        $pdfdata['livello_categoria'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'livello_categoria')->get();
        $pdfdata['indirizzo_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_lav')->get();
        $pdfdata['civico_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'civico_lav')->get();
        $pdfdata['cap_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_lav')->get();
        $pdfdata['citta_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_lav')->get();
        $pdfdata['provincia_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_lav')->get();

        $data = [
            'title' => 'Mandato al CAF',
            'date' => date('m/d/Y'),
            'customer' => $customer,
            'user' => $user,
            'pdfdata' => $pdfdata
        ]; 
            
         $pdf = PDF::loadView('admin.PDF.flussi9', $data);
         return $pdf->stream('Proposta_del_Contratto_di_soggiorno.pdf');
    }

    public function flussi4($id)
    {
        $ids = Invoice::select('customer_id', 'user_id', 'file_id')->where('id', $id)->first();
        $user = DB::table('users')->where('id', $ids->user_id)->first();
        $customer = DB::table('customers')->where('id', $ids->customer_id)->first();

        $pdfdata['nome'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'nome')->get();
        $pdfdata['cognome'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cognome')->get();
        $pdfdata['luogo_nascita'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'luogo_nascita')->get();
        $pdfdata['data_nascita'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'data_nascita')->get();
        $pdfdata['sesso'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'sesso')->get();
        $pdfdata['cittadinanza'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cittadinanza')->get();
        $pdfdata['paese_residenza'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'paese_residenza')->get();
        $pdfdata['ragione_sociale'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'ragione_sociale')->get();
        $pdfdata['cf_azienda'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cf_azienda')->get();
        $pdfdata['flussi_partita_iva'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'flussi_partita_iva')->get();
        $pdfdata['indirizzo_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_sede')->get();
        $pdfdata['citta_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_sede')->get();
        $pdfdata['provincia_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_sede')->get();
        $pdfdata['cap_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_sede')->get();
        $pdfdata['indirizzo_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_operativa')->get();
        $pdfdata['citta_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_operativa')->get();
        $pdfdata['provincia_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_operativa')->get();
        $pdfdata['cap_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_operativa')->get();
        $pdfdata['matricola_inps'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'matricola_inps')->get();
        $pdfdata['sede_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'sede_inail')->get();
        $pdfdata['codice_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'codice_inail')->get();
        $pdfdata['controllo_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'controllo_inail')->get();
        $pdfdata['provincia_cciaa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_cciaa')->get();
        $pdfdata['numero_cciaa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'numero_cciaa')->get();
        $pdfdata['data_iscrizione'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'data_iscrizione')->get();
        $pdfdata['numero_dipendenti'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'numero_dipendenti')->get();
        $pdfdata['codice_sdi'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'codice_sdi')->get();
        $pdfdata['fatturato_annoprima'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'fatturato_annoprima')->get();
        $pdfdata['redditi_annoprima'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'redditi_annoprima')->get();
        $pdfdata['tipologia_contratto'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'tipologia_contratto')->get();
        $pdfdata['tempo'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'tempo')->get();
        $pdfdata['mansoine'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'mansoine')->get();
        $pdfdata['mesi_lavoro'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'mesi_lavoro')->get();
        $pdfdata['orario_settimanale'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'orario_settimanale')->get();
        $pdfdata['livello_categoria'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'livello_categoria')->get();
        $pdfdata['indirizzo_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_lav')->get();
        $pdfdata['civico_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'civico_lav')->get();
        $pdfdata['cap_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_lav')->get();
        $pdfdata['citta_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_lav')->get();
        $pdfdata['provincia_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_lav')->get();

        $data = [
            'title' => 'Mandato al CAF',
            'date' => date('m/d/Y'),
            'customer' => $customer,
            'user' => $user,
            'pdfdata' => $pdfdata
        ]; 
            
         $pdf = PDF::loadView('admin.PDF.flussi4', $data);
         return $pdf->stream('Impegno_Ospitalità_lavoratore_Flussi.pdf');
    }


    public function flussi8($id)
    {
        $ids = Invoice::select('customer_id', 'user_id', 'file_id')->where('id', $id)->first();
        $user = DB::table('users')->where('id', $ids->user_id)->first();
        $customer = DB::table('customers')->where('id', $ids->customer_id)->first();

        $pdfdata['nome'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'nome')->get();
        $pdfdata['cognome'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cognome')->get();
        $pdfdata['luogo_nascita'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'luogo_nascita')->get();
        $pdfdata['data_nascita'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'data_nascita')->get();
        $pdfdata['sesso'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'sesso')->get();
        $pdfdata['cittadinanza'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cittadinanza')->get();
        $pdfdata['paese_residenza'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'paese_residenza')->get();
        $pdfdata['ragione_sociale'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'ragione_sociale')->get();
        $pdfdata['cf_azienda'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cf_azienda')->get();
        $pdfdata['flussi_partita_iva'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'flussi_partita_iva')->get();
        $pdfdata['indirizzo_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_sede')->get();
        $pdfdata['citta_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_sede')->get();
        $pdfdata['provincia_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_sede')->get();
        $pdfdata['cap_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_sede')->get();
        $pdfdata['indirizzo_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_operativa')->get();
        $pdfdata['citta_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_operativa')->get();
        $pdfdata['provincia_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_operativa')->get();
        $pdfdata['cap_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_operativa')->get();
        $pdfdata['matricola_inps'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'matricola_inps')->get();
        $pdfdata['sede_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'sede_inail')->get();
        $pdfdata['codice_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'codice_inail')->get();
        $pdfdata['controllo_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'controllo_inail')->get();
        $pdfdata['provincia_cciaa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_cciaa')->get();
        $pdfdata['numero_cciaa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'numero_cciaa')->get();
        $pdfdata['data_iscrizione'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'data_iscrizione')->get();
        $pdfdata['numero_dipendenti'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'numero_dipendenti')->get();
        $pdfdata['codice_sdi'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'codice_sdi')->get();
        $pdfdata['fatturato_annoprima'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'fatturato_annoprima')->get();
        $pdfdata['redditi_annoprima'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'redditi_annoprima')->get();
        $pdfdata['tipologia_contratto'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'tipologia_contratto')->get();
        $pdfdata['tempo'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'tempo')->get();
        $pdfdata['mansoine'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'mansoine')->get();
        $pdfdata['mesi_lavoro'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'mesi_lavoro')->get();
        $pdfdata['orario_settimanale'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'orario_settimanale')->get();
        $pdfdata['livello_categoria'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'livello_categoria')->get();
        $pdfdata['indirizzo_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_lav')->get();
        $pdfdata['civico_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'civico_lav')->get();
        $pdfdata['cap_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_lav')->get();
        $pdfdata['citta_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_lav')->get();
        $pdfdata['provincia_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_lav')->get();

        $data = [
            'title' => 'Mandato al CAF',
            'date' => date('m/d/Y'),
            'customer' => $customer,
            'user' => $user,
            'pdfdata' => $pdfdata
        ]; 
            
         $pdf = PDF::loadView('admin.PDF.flussi8', $data);
         return $pdf->stream('Autodichiarazione_previdenziale_e_Fisacale.pdf');
    }

    public function flussi10($id)
    {
        $ids = Invoice::select('customer_id', 'user_id', 'file_id')->where('id', $id)->first();
        $user = DB::table('users')->where('id', $ids->user_id)->first();
        $customer = DB::table('customers')->where('id', $ids->customer_id)->first();

        $pdfdata['nome'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'nome')->get();
        $pdfdata['cognome'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cognome')->get();
        $pdfdata['luogo_nascita'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'luogo_nascita')->get();
        $pdfdata['data_nascita'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'data_nascita')->get();
        $pdfdata['sesso'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'sesso')->get();
        $pdfdata['cittadinanza'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cittadinanza')->get();
        $pdfdata['paese_residenza'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'paese_residenza')->get();
        $pdfdata['ragione_sociale'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'ragione_sociale')->get();
        $pdfdata['cf_azienda'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cf_azienda')->get();
        $pdfdata['flussi_partita_iva'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'flussi_partita_iva')->get();
        $pdfdata['indirizzo_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_sede')->get();
        $pdfdata['citta_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_sede')->get();
        $pdfdata['provincia_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_sede')->get();
        $pdfdata['cap_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_sede')->get();
        $pdfdata['indirizzo_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_operativa')->get();
        $pdfdata['citta_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_operativa')->get();
        $pdfdata['provincia_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_operativa')->get();
        $pdfdata['cap_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_operativa')->get();
        $pdfdata['matricola_inps'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'matricola_inps')->get();
        $pdfdata['sede_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'sede_inail')->get();
        $pdfdata['codice_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'codice_inail')->get();
        $pdfdata['controllo_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'controllo_inail')->get();
        $pdfdata['provincia_cciaa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_cciaa')->get();
        $pdfdata['numero_cciaa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'numero_cciaa')->get();
        $pdfdata['data_iscrizione'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'data_iscrizione')->get();
        $pdfdata['numero_dipendenti'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'numero_dipendenti')->get();
        $pdfdata['codice_sdi'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'codice_sdi')->get();
        $pdfdata['fatturato_annoprima'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'fatturato_annoprima')->get();
        $pdfdata['redditi_annoprima'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'redditi_annoprima')->get();
        $pdfdata['tipologia_contratto'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'tipologia_contratto')->get();
        $pdfdata['tempo'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'tempo')->get();
        $pdfdata['mansoine'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'mansoine')->get();
        $pdfdata['mesi_lavoro'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'mesi_lavoro')->get();
        $pdfdata['orario_settimanale'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'orario_settimanale')->get();
        $pdfdata['livello_categoria'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'livello_categoria')->get();
        $pdfdata['indirizzo_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_lav')->get();
        $pdfdata['civico_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'civico_lav')->get();
        $pdfdata['cap_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_lav')->get();
        $pdfdata['citta_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_lav')->get();
        $pdfdata['provincia_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_lav')->get();

        $data = [
            'title' => 'Mandato al CAF',
            'date' => date('m/d/Y'),
            'customer' => $customer,
            'user' => $user,
            'pdfdata' => $pdfdata
        ]; 
            
         $pdf = PDF::loadView('admin.PDF.flussi10', $data);
         return $pdf->stream('Dichiarazione_Centri_per_limpiego.pdf');
    }   

    public function flussi5($id)
    {
        $ids = Invoice::select('customer_id', 'user_id', 'file_id')->where('id', $id)->first();
        $user = DB::table('users')->where('id', $ids->user_id)->first();
        $customer = DB::table('customers')->where('id', $ids->customer_id)->first();

        $pdfdata['nome'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'nome')->get();
        $pdfdata['cognome'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cognome')->get();
        $pdfdata['luogo_nascita'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'luogo_nascita')->get();
        $pdfdata['data_nascita'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'data_nascita')->get();
        $pdfdata['sesso'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'sesso')->get();
        $pdfdata['cittadinanza'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cittadinanza')->get();
        $pdfdata['paese_residenza'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'paese_residenza')->get();
        $pdfdata['ragione_sociale'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'ragione_sociale')->get();
        $pdfdata['cf_azienda'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cf_azienda')->get();
        $pdfdata['flussi_partita_iva'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'flussi_partita_iva')->get();
        $pdfdata['indirizzo_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_sede')->get();
        $pdfdata['citta_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_sede')->get();
        $pdfdata['provincia_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_sede')->get();
        $pdfdata['cap_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_sede')->get();
        $pdfdata['indirizzo_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_operativa')->get();
        $pdfdata['citta_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_operativa')->get();
        $pdfdata['provincia_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_operativa')->get();
        $pdfdata['cap_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_operativa')->get();
        $pdfdata['matricola_inps'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'matricola_inps')->get();
        $pdfdata['sede_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'sede_inail')->get();
        $pdfdata['codice_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'codice_inail')->get();
        $pdfdata['controllo_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'controllo_inail')->get();
        $pdfdata['provincia_cciaa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_cciaa')->get();
        $pdfdata['numero_cciaa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'numero_cciaa')->get();
        $pdfdata['data_iscrizione'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'data_iscrizione')->get();
        $pdfdata['numero_dipendenti'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'numero_dipendenti')->get();
        $pdfdata['codice_sdi'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'codice_sdi')->get();
        $pdfdata['fatturato_annoprima'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'fatturato_annoprima')->get();
        $pdfdata['redditi_annoprima'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'redditi_annoprima')->get();
        $pdfdata['tipologia_contratto'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'tipologia_contratto')->get();
        $pdfdata['tempo'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'tempo')->get();
        $pdfdata['mansoine'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'mansoine')->get();
        $pdfdata['mesi_lavoro'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'mesi_lavoro')->get();
        $pdfdata['orario_settimanale'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'orario_settimanale')->get();
        $pdfdata['livello_categoria'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'livello_categoria')->get();
        $pdfdata['indirizzo_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_lav')->get();
        $pdfdata['civico_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'civico_lav')->get();
        $pdfdata['cap_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_lav')->get();
        $pdfdata['citta_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_lav')->get();
        $pdfdata['provincia_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_lav')->get();

        $data = [
            'title' => 'Mandato al CAF',
            'date' => date('m/d/Y'),
            'customer' => $customer,
            'user' => $user,
            'pdfdata' => $pdfdata
        ]; 
            
         $pdf = PDF::loadView('admin.PDF.flussi5', $data);
         return $pdf->stream('Impegno_certificato_idoneita_Alloggiativa.pdf');
    }


    public function flussi7($id)
    {
        $ids = Invoice::select('customer_id', 'user_id', 'file_id')->where('id', $id)->first();
        $user = DB::table('users')->where('id', $ids->user_id)->first();
        $customer = DB::table('customers')->where('id', $ids->customer_id)->first();

        $pdfdata['nome'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'nome')->get();
        $pdfdata['cognome'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cognome')->get();
        $pdfdata['luogo_nascita'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'luogo_nascita')->get();
        $pdfdata['data_nascita'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'data_nascita')->get();
        $pdfdata['sesso'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'sesso')->get();
        $pdfdata['cittadinanza'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cittadinanza')->get();
        $pdfdata['paese_residenza'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'paese_residenza')->get();
        $pdfdata['ragione_sociale'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'ragione_sociale')->get();
        $pdfdata['cf_azienda'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cf_azienda')->get();
        $pdfdata['flussi_partita_iva'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'flussi_partita_iva')->get();
        $pdfdata['indirizzo_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_sede')->get();
        $pdfdata['citta_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_sede')->get();
        $pdfdata['provincia_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_sede')->get();
        $pdfdata['cap_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_sede')->get();
        $pdfdata['indirizzo_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_operativa')->get();
        $pdfdata['citta_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_operativa')->get();
        $pdfdata['provincia_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_operativa')->get();
        $pdfdata['cap_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_operativa')->get();
        $pdfdata['matricola_inps'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'matricola_inps')->get();
        $pdfdata['sede_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'sede_inail')->get();
        $pdfdata['codice_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'codice_inail')->get();
        $pdfdata['controllo_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'controllo_inail')->get();
        $pdfdata['provincia_cciaa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_cciaa')->get();
        $pdfdata['numero_cciaa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'numero_cciaa')->get();
        $pdfdata['data_iscrizione'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'data_iscrizione')->get();
        $pdfdata['numero_dipendenti'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'numero_dipendenti')->get();
        $pdfdata['codice_sdi'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'codice_sdi')->get();
        $pdfdata['fatturato_annoprima'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'fatturato_annoprima')->get();
        $pdfdata['redditi_annoprima'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'redditi_annoprima')->get();
        $pdfdata['tipologia_contratto'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'tipologia_contratto')->get();
        $pdfdata['tempo'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'tempo')->get();
        $pdfdata['mansoine'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'mansoine')->get();
        $pdfdata['mesi_lavoro'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'mesi_lavoro')->get();
        $pdfdata['orario_settimanale'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'orario_settimanale')->get();
        $pdfdata['livello_categoria'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'livello_categoria')->get();
        $pdfdata['indirizzo_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_lav')->get();
        $pdfdata['civico_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'civico_lav')->get();
        $pdfdata['cap_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_lav')->get();
        $pdfdata['citta_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_lav')->get();
        $pdfdata['provincia_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_lav')->get();

        $data = [
            'title' => 'Mandato al CAF',
            'date' => date('m/d/Y'),
            'customer' => $customer,
            'user' => $user,
            'pdfdata' => $pdfdata
        ]; 
            
         $pdf = PDF::loadView('admin.PDF.flussi7', $data);
         return $pdf->stream('Impegno_Documentoo_Asseverazione.pdf');
    }
    

    public function flussi6($id)
    {
        $ids = Invoice::select('customer_id', 'user_id', 'file_id')->where('id', $id)->first();
        $user = DB::table('users')->where('id', $ids->user_id)->first();
        $customer = DB::table('customers')->where('id', $ids->customer_id)->first();

        $pdfdata['nome'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'nome')->get();
        $pdfdata['cognome'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cognome')->get();
        $pdfdata['luogo_nascita'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'luogo_nascita')->get();
        $pdfdata['data_nascita'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'data_nascita')->get();
        $pdfdata['sesso'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'sesso')->get();
        $pdfdata['cittadinanza'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cittadinanza')->get();
        $pdfdata['paese_residenza'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'paese_residenza')->get();
        $pdfdata['ragione_sociale'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'ragione_sociale')->get();
        $pdfdata['cf_azienda'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cf_azienda')->get();
        $pdfdata['flussi_partita_iva'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'flussi_partita_iva')->get();
        $pdfdata['indirizzo_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_sede')->get();
        $pdfdata['citta_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_sede')->get();
        $pdfdata['provincia_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_sede')->get();
        $pdfdata['cap_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_sede')->get();
        $pdfdata['indirizzo_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_operativa')->get();
        $pdfdata['citta_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_operativa')->get();
        $pdfdata['provincia_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_operativa')->get();
        $pdfdata['cap_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_operativa')->get();
        $pdfdata['matricola_inps'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'matricola_inps')->get();
        $pdfdata['sede_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'sede_inail')->get();
        $pdfdata['codice_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'codice_inail')->get();
        $pdfdata['controllo_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'controllo_inail')->get();
        $pdfdata['provincia_cciaa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_cciaa')->get();
        $pdfdata['numero_cciaa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'numero_cciaa')->get();
        $pdfdata['data_iscrizione'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'data_iscrizione')->get();
        $pdfdata['numero_dipendenti'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'numero_dipendenti')->get();
        $pdfdata['codice_sdi'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'codice_sdi')->get();
        $pdfdata['fatturato_annoprima'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'fatturato_annoprima')->get();
        $pdfdata['redditi_annoprima'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'redditi_annoprima')->get();
        $pdfdata['tipologia_contratto'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'tipologia_contratto')->get();
        $pdfdata['tempo'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'tempo')->get();
        $pdfdata['mansoine'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'mansoine')->get();
        $pdfdata['mesi_lavoro'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'mesi_lavoro')->get();
        $pdfdata['orario_settimanale'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'orario_settimanale')->get();
        $pdfdata['livello_categoria'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'livello_categoria')->get();
        $pdfdata['indirizzo_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_lav')->get();
        $pdfdata['civico_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'civico_lav')->get();
        $pdfdata['cap_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_lav')->get();
        $pdfdata['citta_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_lav')->get();
        $pdfdata['provincia_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_lav')->get();

        $data = [
            'title' => 'Mandato al CAF',
            'date' => date('m/d/Y'),
            'customer' => $customer,
            'user' => $user,
            'pdfdata' => $pdfdata
        ]; 
            
         $pdf = PDF::loadView('admin.PDF.flussi6', $data);
         return $pdf->stream('Impegno_DURC.pdf');
    }

    public function flussi1($id)
    {
        $ids = Invoice::select('customer_id', 'user_id', 'file_id')->where('id', $id)->first();
        $user = DB::table('users')->where('id', $ids->user_id)->first();
        $customer = DB::table('customers')->where('id', $ids->customer_id)->first();

        $pdfdata['nome'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'nome')->get();
        $pdfdata['cognome'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cognome')->get();
        $pdfdata['luogo_nascita'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'luogo_nascita')->get();
        $pdfdata['data_nascita'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'data_nascita')->get();
        $pdfdata['sesso'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'sesso')->get();
        $pdfdata['cittadinanza'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cittadinanza')->get();
        $pdfdata['paese_residenza'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'paese_residenza')->get();
        $pdfdata['ragione_sociale'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'ragione_sociale')->get();
        $pdfdata['cf_azienda'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cf_azienda')->get();
        $pdfdata['flussi_partita_iva'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'flussi_partita_iva')->get();
        $pdfdata['indirizzo_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_sede')->get();
        $pdfdata['citta_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_sede')->get();
        $pdfdata['provincia_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_sede')->get();
        $pdfdata['cap_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_sede')->get();
        $pdfdata['indirizzo_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_operativa')->get();
        $pdfdata['citta_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_operativa')->get();
        $pdfdata['provincia_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_operativa')->get();
        $pdfdata['cap_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_operativa')->get();
        $pdfdata['matricola_inps'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'matricola_inps')->get();
        $pdfdata['sede_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'sede_inail')->get();
        $pdfdata['codice_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'codice_inail')->get();
        $pdfdata['controllo_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'controllo_inail')->get();
        $pdfdata['provincia_cciaa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_cciaa')->get();
        $pdfdata['numero_cciaa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'numero_cciaa')->get();
        $pdfdata['data_iscrizione'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'data_iscrizione')->get();
        $pdfdata['numero_dipendenti'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'numero_dipendenti')->get();
        $pdfdata['codice_sdi'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'codice_sdi')->get();
        $pdfdata['fatturato_annoprima'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'fatturato_annoprima')->get();
        $pdfdata['redditi_annoprima'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'redditi_annoprima')->get();
        $pdfdata['tipologia_contratto'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'tipologia_contratto')->get();
        $pdfdata['tempo'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'tempo')->get();
        $pdfdata['mansoine'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'mansoine')->get();
        $pdfdata['mesi_lavoro'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'mesi_lavoro')->get();
        $pdfdata['orario_settimanale'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'orario_settimanale')->get();
        $pdfdata['livello_categoria'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'livello_categoria')->get();
        $pdfdata['indirizzo_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_lav')->get();
        $pdfdata['civico_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'civico_lav')->get();
        $pdfdata['cap_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_lav')->get();
        $pdfdata['citta_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_lav')->get();
        $pdfdata['provincia_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_lav')->get();

        $data = [
            'title' => 'Mandato al CAF',
            'date' => date('m/d/Y'),
            'customer' => $customer,
            'user' => $user,
            'pdfdata' => $pdfdata
        ]; 
            
         $pdf = PDF::loadView('admin.PDF.flussi1', $data);
         $customPaper = array(0,0,680,1200);
         $pdf->setPaper($customPaper);
         return $pdf->stream('Privecy_e_GDPR.pdf');
    }

    public function flussi2($id)
    {
        $ids = Invoice::select('customer_id', 'user_id', 'file_id')->where('id', $id)->first();
        $user = DB::table('users')->where('id', $ids->user_id)->first();
        $customer = DB::table('customers')->where('id', $ids->customer_id)->first();

        $pdfdata['nome'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'nome')->get();
        $pdfdata['cognome'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cognome')->get();
        $pdfdata['luogo_nascita'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'luogo_nascita')->get();
        $pdfdata['data_nascita'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'data_nascita')->get();
        $pdfdata['sesso'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'sesso')->get();
        $pdfdata['cittadinanza'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cittadinanza')->get();
        $pdfdata['paese_residenza'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'paese_residenza')->get();
        $pdfdata['ragione_sociale'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'ragione_sociale')->get();
        $pdfdata['cf_azienda'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cf_azienda')->get();
        $pdfdata['flussi_partita_iva'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'flussi_partita_iva')->get();
        $pdfdata['indirizzo_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_sede')->get();
        $pdfdata['citta_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_sede')->get();
        $pdfdata['provincia_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_sede')->get();
        $pdfdata['cap_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_sede')->get();
        $pdfdata['indirizzo_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_operativa')->get();
        $pdfdata['citta_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_operativa')->get();
        $pdfdata['provincia_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_operativa')->get();
        $pdfdata['cap_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_operativa')->get();
        $pdfdata['matricola_inps'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'matricola_inps')->get();
        $pdfdata['sede_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'sede_inail')->get();
        $pdfdata['codice_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'codice_inail')->get();
        $pdfdata['controllo_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'controllo_inail')->get();
        $pdfdata['provincia_cciaa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_cciaa')->get();
        $pdfdata['numero_cciaa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'numero_cciaa')->get();
        $pdfdata['data_iscrizione'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'data_iscrizione')->get();
        $pdfdata['numero_dipendenti'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'numero_dipendenti')->get();
        $pdfdata['codice_sdi'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'codice_sdi')->get();
        $pdfdata['fatturato_annoprima'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'fatturato_annoprima')->get();
        $pdfdata['redditi_annoprima'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'redditi_annoprima')->get();
        $pdfdata['tipologia_contratto'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'tipologia_contratto')->get();
        $pdfdata['tempo'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'tempo')->get();
        $pdfdata['mansoine'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'mansoine')->get();
        $pdfdata['mesi_lavoro'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'mesi_lavoro')->get();
        $pdfdata['orario_settimanale'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'orario_settimanale')->get();
        $pdfdata['livello_categoria'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'livello_categoria')->get();
        $pdfdata['indirizzo_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_lav')->get();
        $pdfdata['civico_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'civico_lav')->get();
        $pdfdata['cap_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_lav')->get();
        $pdfdata['citta_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_lav')->get();
        $pdfdata['provincia_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_lav')->get();

        $data = [
            'title' => 'Mandato al CAF',
            'date' => date('m/d/Y'),
            'customer' => $customer,
            'user' => $user,
            'pdfdata' => $pdfdata
        ]; 
            
         $pdf = PDF::loadView('admin.PDF.flussi2', $data);
         return $pdf->stream('Mandato_Flussii.pdf');
    }

    public function flussi3($id)
    {
        $ids = Invoice::select('customer_id', 'user_id', 'file_id')->where('id', $id)->first();
        $user = DB::table('users')->where('id', $ids->user_id)->first();
        $customer = DB::table('customers')->where('id', $ids->customer_id)->first();

        $pdfdata['nome'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'nome')->get();
        $pdfdata['cognome'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cognome')->get();
        $pdfdata['luogo_nascita'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'luogo_nascita')->get();
        $pdfdata['data_nascita'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'data_nascita')->get();
        $pdfdata['sesso'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'sesso')->get();
        $pdfdata['cittadinanza'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cittadinanza')->get();
        $pdfdata['paese_residenza'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'paese_residenza')->get();
        $pdfdata['ragione_sociale'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'ragione_sociale')->get();
        $pdfdata['cf_azienda'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cf_azienda')->get();
        $pdfdata['flussi_partita_iva'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'flussi_partita_iva')->get();
        $pdfdata['indirizzo_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_sede')->get();
        $pdfdata['citta_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_sede')->get();
        $pdfdata['provincia_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_sede')->get();
        $pdfdata['cap_sede'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_sede')->get();
        $pdfdata['indirizzo_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_operativa')->get();
        $pdfdata['citta_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_operativa')->get();
        $pdfdata['provincia_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_operativa')->get();
        $pdfdata['cap_operativa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_operativa')->get();
        $pdfdata['matricola_inps'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'matricola_inps')->get();
        $pdfdata['sede_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'sede_inail')->get();
        $pdfdata['codice_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'codice_inail')->get();
        $pdfdata['controllo_inail'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'controllo_inail')->get();
        $pdfdata['provincia_cciaa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_cciaa')->get();
        $pdfdata['numero_cciaa'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'numero_cciaa')->get();
        $pdfdata['data_iscrizione'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'data_iscrizione')->get();
        $pdfdata['numero_dipendenti'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'numero_dipendenti')->get();
        $pdfdata['codice_sdi'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'codice_sdi')->get();
        $pdfdata['fatturato_annoprima'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'fatturato_annoprima')->get();
        $pdfdata['redditi_annoprima'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'redditi_annoprima')->get();
        $pdfdata['tipologia_contratto'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'tipologia_contratto')->get();
        $pdfdata['tempo'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'tempo')->get();
        $pdfdata['mansoine'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'mansoine')->get();
        $pdfdata['mesi_lavoro'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'mesi_lavoro')->get();
        $pdfdata['orario_settimanale'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'orario_settimanale')->get();
        $pdfdata['livello_categoria'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'livello_categoria')->get();
        $pdfdata['indirizzo_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'indirizzo_lav')->get();
        $pdfdata['civico_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'civico_lav')->get();
        $pdfdata['cap_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'cap_lav')->get();
        $pdfdata['citta_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'citta_lav')->get();
        $pdfdata['provincia_lav'] = Pdfdata::select('field_value')->where('file_id', $ids->file_id)->where('field_name', 'provincia_lav')->get();

        $data = [
            'title' => 'Mandato al CAF',
            'date' => date('m/d/Y'),
            'customer' => $customer,
            'user' => $user,
            'pdfdata' => $pdfdata
        ]; 
            
         $pdf = PDF::loadView('admin.PDF.flussi3', $data);
         return $pdf->stream('Delega_Domanda_Flussi.pdf');
    }

    public function Print_Static_PDF($id){
        $pdf_file = DB::table('pdf_files')->where('id',$id)->first();
        $pathToFile = 'upload/static_pdf/'.$pdf_file->upload_pdf_file;
        $headers = [$pdf_file->pdf_file_name];
        return response()->file($pathToFile, $headers);
        // $data["info"] = $pdf_file;
        // $pdf = PDF::loadView('admin.PDF.static.pdf', $data);
        // return $pdf->stream($pathToFile);
    }

}
