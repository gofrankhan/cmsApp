<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\User;
use App\Models\File;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Pdfdata;
use DataTables;
use Debugbar;


class FileController extends Controller
{
    public function FileDataTable(Request $request, $view_type)
    {
        $title = "Files";
        $shop_name = Auth::user()->shop_name;
        $user_type = Auth::user()->user_type;
        $user_id = Auth::user()->id;
        if ($request->ajax()) {
            if($user_type =='admin' && $view_type == 'all'){
                $data = Invoice::select('invoices.id as id', 'invoices.file_id as file_id', 'customers.taxid', 
                                    DB::raw("concat(customers.firstname,' ', customers.lastname) as customer"),
                                    'users.shop_name as shop','services.service', 'invoices.status', 'invoices.lawyer_id', 'invoices.lawyer_price')
                                    ->leftjoin('customers', 'invoices.customer_id', '=', 'customers.id')
                                    ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                                    ->leftjoin('users', 'invoices.user_id', '=', 'users.id')
                                    ->orderByDesc('file_id')
                                    ->get();
            }
            else if ($user_type =='user'){
                $data = Invoice::select('invoices.id as id', 'invoices.file_id as file_id', 'customers.taxid', 
                                    DB::raw("concat(customers.firstname,' ', customers.lastname) as customer"),
                                    'users.shop_name as shop','services.service', 'invoices.status')
                                    ->leftjoin('customers', 'invoices.customer_id', '=', 'customers.id')
                                    ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                                    ->leftjoin('users', 'invoices.user_id', '=', 'users.id')
                                    ->whereIn('invoices.user_id', function($query) use ($shop_name){
                                        $query->select('id')->from('users')->where('shop_name', $shop_name);
                                    })
                                    ->orderByDesc('file_id')
                                    ->get();
            }
            else if ($user_type =='lawyer'){
                $data = nvoice::select('invoices.id as id', 'invoices.file_id as file_id', 'customers.taxid', 
                                DB::raw("concat(customers.firstname,' ', customers.lastname) as customer"),
                                'users.shop_name as shop','services.service', 'invoices.status', 'invoices.lawyer_id', 'invoices.lawyer_price')
                                    ->leftjoin('customers', 'invoices.customer_id', '=', 'customers.id')
                                    ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                                    ->leftjoin('users', 'invoices.user_id', '=', 'users.id')
                                    ->where('invoices.lawyer_id', '=', $user_id)
                                    ->orderByDesc('file_id')
                                    ->get();
            }
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $user_type = Auth::user()->user_type;
                    if($user_type == 'admin'){
                        $btn = '
                        <div style="width:150px" class="row">
                        <form>
                            <a class="btn btn-outline-secondary btn-sm edit" href="'.route('file.show',$row->file_id).'" target="_blank" title="Show">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a class="btn btn-outline-secondary btn-sm edit" href="'.route('file.edit',$row->file_id).'"target="_blank" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a type="submit" class="btn btn-danger btn-sm edit" data-id="'. $row->id.'" title="Delete">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </form>
                        </div>';
                        return $btn;
                    }else{
                        if($row->status == 'Completed' || $row->status == 'Cancelled' ){
                            $btn = '
                            <a class="btn btn-outline-secondary btn-sm edit" href="'.route('file.show',$row->file_id).'" target="_blank" title="Show">
                                <i class="fas fa-eye"></i>
                            </a>
                            ';
                            return $btn;
                        }else{
                            $btn = '
                            <a class="btn btn-outline-secondary btn-sm edit" href="'.route('file.show',$row->file_id).'" target="_blank" title="Show">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a class="btn btn-outline-secondary btn-sm edit" href="'.route('file.edit',$row->file_id).'" target="_blank" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            ';
                            return $btn;
                        }
                    }
                })
                ->addColumn('icon', function($row){
                    $btn = "";
                    if($row->status == "Completed")
                        $btn = '<div class="font-size-13"><i class="ri-checkbox-blank-circle-fill font-size-10 text-success align-middle me-2"></i></div>';
                    else if($row->status == "Pending") 
                        $btn = '<div class="font-size-13"><i class="ri-checkbox-blank-circle-fill font-size-10 text-warning align-middle me-2"></i></div>';
                    else if($row->status == "Submitted")
                        $btn = '<div class="font-size-13"><i class="ri-checkbox-blank-circle-fill font-size-10 text-dark align-middle me-2"></i></div>';
                    else if($row->status == "Cancelled")
                        $btn = '<div class="font-size-13"><i class="ri-checkbox-blank-circle-fill font-size-10 text-danger align-middle me-2"></i></div>';
                    return $btn;
                })
                ->addColumn('id', function($row){
                    $btn = '<label style="display:none">$row->id</label>';
                    return $btn;
                })
                ->rawColumns(['action', 'icon', 'id'])
                ->make(true);
        }
        return view('admin.file_data_table', compact('title'));
    }

    
    public function MovementDataTable(Request $request)
    {
        $title = "Movement";
        $shop_name = Auth::user()->shop_name;
        $user_type = Auth::user()->user_type;
        $user_id = Auth::user()->id;
        if ($request->ajax()) {    
            if($user_type == 'lawyer') {
                $data = Invoice::select('invoices.file_id as file_id', 'invoices.description', 'invoices.lawyer_price as amount', DB::raw("concat(customers.firstname,' ', customers.lastname) as customer"),'services.service')
                                ->leftjoin('customers', 'invoices.customer_id', '=', 'customers.id')
                                ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                                ->leftjoin('users', 'invoices.user_id', '=', 'users.id')
                                ->where('invoices.status', '=', 'Completed')
                                ->where('invoices.lawyer_id', $user_id)
                                ->get();
                    return Datatables::of($data)
                    ->make(true);
                
            } else{
                $data = Invoice::select('invoices.file_id as file_id', 'invoices.description', 'invoices.price as amount', DB::raw("concat(customers.firstname,' ', customers.lastname) as customer"),'services.service')
                                ->leftjoin('customers', 'invoices.customer_id', '=', 'customers.id')
                                ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                                ->leftjoin('users', 'invoices.user_id', '=', 'users.id')
                                ->where('invoices.status', '=', 'Completed')
                                ->whereIn('invoices.user_id', function($query) use ($shop_name){
                                    $query->select('id')->from('users')->where('shop_name', $shop_name);
                                })->get();
                    return Datatables::of($data)
                    ->make(true);
            }       
            
        }

        if($user_type == 'lawyer') {
            $total_sum = Invoice::leftjoin('users', 'invoices.lawyer_id', '=', 'users.id')
                        ->where('invoices.status', '=', 'Completed')
                        ->where('invoices.lawyer_id', $user_id)
                        ->sum('invoices.lawyer_price');
        } else {
            $total_sum = Invoice::leftjoin('users', 'invoices.user_id', '=', 'users.id')
                ->where('invoices.status', '=', 'Completed')
                ->whereIn('invoices.user_id', function($query) use ($shop_name){
                    $query->select('id')->from('users')->where('shop_name', $shop_name);
                })->sum('invoices.price');
        }

        return view('admin.movement_data_table', compact('title', 'total_sum'));
    }

    public function MovementDataTableAll(Request $request)
    {
        $title = "Movement";
        $shop_name = Auth::user()->shop_name;
        $user_type = Auth::user()->user_type;
        if ($request->ajax()) {
            if($user_type =='admin'){
                $data = Invoice::select('invoices.file_id as file_id', 'invoices.description', 'invoices.price as amount', DB::raw("concat(customers.firstname,' ', customers.lastname) as customer"),'services.service')
                                    ->leftjoin('customers', 'invoices.customer_id', '=', 'customers.id')
                                    ->leftjoin('services', 'invoices.service_id', '=', 'services.id')
                                    ->where('invoices.status', '=', 'Completed')
                                    ->get();
            }
            return Datatables::of($data)
            ->make(true);
        }
        return view('admin.movement_data_table_all', compact('title'));
    }

    public function FileStore(Request $request)
    {
        $file_id = Invoice::max('file_id');
        $file_id += 1;
        $user_id = Auth::user()->id;
        $user_type = Auth::user()->user_type;
        $shop_name = Auth::user()->shop_name;
        $lawyer_id = null;
        if($user_type == 'lawyer')
            $lawyer_id = $user_id;
        
        if($request->user != null && !empty($request->user)){
            $user_info = User::select('id','shop_name', 'user_type')->where('username', $request->user)->first();
            if($user_type == 'lawyer'){
                $lawyer_id = $user_id;
                $shop_name = $user_info->shop_name;
                $user_id = $user_info->id;
            }else{
                $user_type_1 = $user_info->user_type;
                if($user_type_1 == 'lawyer')
                    $lawyer_id = $user_info->id;
                $shop_name = $user_info->shop_name;
                $user_id = $user_info->id;
            }
        }
        if((!empty($request->service) || strtolower($request->category) == 'pagamento') && !empty($request->taxid)){
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
            $file->user_id = $user_id;
            $file->lawyer_id = $lawyer_id;
            
            $file->status = "Submitted";
            if(strtolower($request->category) == 'pagamento'){
                $service_id = Service::select('id')->where('category', $request->category)->first();
                $file->service_id = $service_id->id;
                $file->price = -$request->pay_amount;
                $file->lawyer_price = -$request->pay_amount;
                $file->description = $request->description;
            }else{
                $service_id = Service::select('id', 'price')->where('service', $request->service)->first();
                $file->service_id = $service_id->id;
                $file->price = $service_id->price;
            }
            $file->save();
            $notification = array(
                'message' => 'File created successfully!', 
                'alert-type' => 'success'
            );
            return response()->json(['success' => true]);
        }else{
            $notification = array(
                'message' => 'No Service or Tax ID found', 
                'alert-type' => 'error'
            );
            return response()->json(['error' => true]);
        }

    }

    public function UpdateService(Request $request){
        $invoice_id = Invoice::select('id')->where('file_id', $request->file_id_no)->first();
        $invoice = Invoice::find($invoice_id->id);
        $service_id = Service::select('id')->where('service', $request->service2)->first();
        $invoice->service_id = intval($service_id->id);
        $invoice->save();
        return redirect()->back();
    }

    public function UpdateFileStatusAndPrice(Request $request)
    {

        $invoice_id = Invoice::select('id')->where('file_id', $request->file_id_no)->first();
        $invoice = Invoice::find($invoice_id->id);
        $invoice->status = $request->file_status;
        $invoice->price = intval($request->pagamento);
        $invoice->lawyer_price = intval($request->pagamento_lawyer);
        $invoice->save();
        
        if($request->anno != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'anno');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'anno')
                        ->update(['field_value' => $request->anno]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "anno";
                $pdfdata->field_value= $request->anno;
                $pdfdata->save();
            }
        }
        if($request->rif != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'rif');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'rif')
                        ->update(['field_value' => $request->rif]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "rif";
                $pdfdata->field_value= $request->rif;
                $pdfdata->save();
            }
        }
        if($request->registration_no != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'registration_no');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'registration_no')
                        ->update(['field_value' => $request->registration_no]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "registration_no";
                $pdfdata->field_value= $request->registration_no;
                $pdfdata->save();
            }
        }
        if($request->registration_date != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'registration_date');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'registration_date')
                        ->update(['field_value' => $request->registration_date]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "registration_date";
                $pdfdata->field_value= $request->registration_date;
                $pdfdata->save();
            }
        }
        if($request->common_chamber_of_commerce != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'common_chamber_of_commerce');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'common_chamber_of_commerce')
                        ->update(['field_value' => $request->common_chamber_of_commerce]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "common_chamber_of_commerce";
                $pdfdata->field_value= $request->common_chamber_of_commerce;
                $pdfdata->save();
            }
        }
        if($request->indirizzo != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'indirizzo');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'indirizzo')
                        ->update(['field_value' => $request->indirizzo]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "indirizzo";
                $pdfdata->field_value= $request->indirizzo;
                $pdfdata->save();
            }
        }
        if($request->civico != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'civico');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'civico')
                        ->update(['field_value' => $request->civico]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "civico";
                $pdfdata->field_value= $request->civico;
                $pdfdata->save();
            }
        }
        if($request->cap != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'cap');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'cap')
                        ->update(['field_value' => $request->cap]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "cap";
                $pdfdata->field_value= $request->cap;
                $pdfdata->save();
            }
        }
        if($request->citta != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'citta');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'citta')
                        ->update(['field_value' => $request->citta]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "citta";
                $pdfdata->field_value= $request->citta;
                $pdfdata->save();
            }
        }
        if($request->provincia != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'provincia');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'provincia')
                        ->update(['field_value' => $request->provincia]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "provincia";
                $pdfdata->field_value= $request->provincia;
                $pdfdata->save();
            }
        }
        if($request->partita_iva != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'partita_iva');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'partita_iva')
                        ->update(['field_value' => $request->partita_iva]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "partita_iva";
                $pdfdata->field_value= $request->partita_iva;
                $pdfdata->save();
            }
        }
        if($request->codice_fiscale != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'codice_fiscale');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'codice_fiscale')
                        ->update(['field_value' => $request->codice_fiscale]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "codice_fiscale";
                $pdfdata->field_value= $request->codice_fiscale;
                $pdfdata->save();
            }
        }
        if($request->codice_ateco != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'codice_ateco');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'codice_ateco')
                        ->update(['field_value' => $request->codice_ateco]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "codice_ateco";
                $pdfdata->field_value= $request->codice_ateco;
                $pdfdata->save();
            }
        }
        if($request->tipo_attivita != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'tipo_attivita');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'tipo_attivita')
                        ->update(['field_value' => $request->tipo_attivita]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "tipo_attivita";
                $pdfdata->field_value= $request->tipo_attivita;
                $pdfdata->save();
            }
        }
        if($request->reddito != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'reddito');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'reddito')
                        ->update(['field_value' => $request->reddito]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "reddito";
                $pdfdata->field_value= $request->reddito;
                $pdfdata->save();
            }
        }
        //Flussi 2023
        if($request->nome != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'nome');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'nome')
                        ->update(['field_value' => $request->nome]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "nome";
                $pdfdata->field_value= $request->nome;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->cognome != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'cognome');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'cognome')
                        ->update(['field_value' => $request->cognome]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "cognome";
                $pdfdata->field_value= $request->cognome;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->luogo_nascita != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'luogo_nascita');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'luogo_nascita')
                        ->update(['field_value' => $request->luogo_nascita]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "luogo_nascita";
                $pdfdata->field_value= $request->luogo_nascita;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->data_nascita != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'data_nascita');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'data_nascita')
                        ->update(['field_value' => $request->data_nascita]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "data_nascita";
                $pdfdata->field_value= $request->data_nascita;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->sesso != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'sesso');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'sesso')
                        ->update(['field_value' => $request->sesso]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "sesso";
                $pdfdata->field_value= $request->sesso;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->cittadinanza != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'cittadinanza');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'cittadinanza')
                        ->update(['field_value' => $request->cittadinanza]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "cittadinanza";
                $pdfdata->field_value= $request->cittadinanza;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->paese_residenza != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'paese_residenza');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'paese_residenza')
                        ->update(['field_value' => $request->paese_residenza]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "paese_residenza";
                $pdfdata->field_value= $request->paese_residenza;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->ragione_sociale != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'ragione_sociale');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'ragione_sociale')
                        ->update(['field_value' => $request->ragione_sociale]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "ragione_sociale";
                $pdfdata->field_value= $request->ragione_sociale;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->cf_azienda != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'cf_azienda');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'cf_azienda')
                        ->update(['field_value' => $request->cf_azienda]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "cf_azienda";
                $pdfdata->field_value= $request->cf_azienda;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->partita_iva != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'partita_iva');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'partita_iva')
                        ->update(['field_value' => $request->partita_iva]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "partita_iva";
                $pdfdata->field_value= $request->partita_iva;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->indirizzo_sede != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'indirizzo_sede');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'indirizzo_sede')
                        ->update(['field_value' => $request->indirizzo_sede]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "indirizzo_sede";
                $pdfdata->field_value= $request->indirizzo_sede;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->citta_sede != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'citta_sede');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'citta_sede')
                        ->update(['field_value' => $request->citta_sede]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "citta_sede";
                $pdfdata->field_value= $request->citta_sede;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->provincia_sede != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'provincia_sede');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'provincia_sede')
                        ->update(['field_value' => $request->provincia_sede]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "provincia_sede";
                $pdfdata->field_value= $request->provincia_sede;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->cap_sede != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'cap_sede');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'cap_sede')
                        ->update(['field_value' => $request->cap_sede]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "cap_sede";
                $pdfdata->field_value= $request->cap_sede;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->indirizzo_operativa != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'indirizzo_operativa');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'indirizzo_operativa')
                        ->update(['field_value' => $request->indirizzo_operativa]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "indirizzo_operativa";
                $pdfdata->field_value= $request->indirizzo_operativa;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->citta_operativa != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'citta_operativa');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'citta_operativa')
                        ->update(['field_value' => $request->citta_operativa]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "citta_operativa";
                $pdfdata->field_value= $request->citta_operativa;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->provincia_operativa != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'provincia_operativa');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'provincia_operativa')
                        ->update(['field_value' => $request->provincia_operativa]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "provincia_operativa";
                $pdfdata->field_value= $request->provincia_operativa;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->cap_operativa != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'cap_operativa');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'cap_operativa')
                        ->update(['field_value' => $request->cap_operativa]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "cap_operativa";
                $pdfdata->field_value= $request->cap_operativa;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->matricola_inps != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'matricola_inps');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'matricola_inps')
                        ->update(['field_value' => $request->matricola_inps]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "matricola_inps";
                $pdfdata->field_value= $request->matricola_inps;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->sede_inail != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'sede_inail');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'sede_inail')
                        ->update(['field_value' => $request->sede_inail]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "sede_inail";
                $pdfdata->field_value= $request->sede_inail;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->codice_inail != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'codice_inail');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'codice_inail')
                        ->update(['field_value' => $request->codice_inail]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "codice_inail";
                $pdfdata->field_value= $request->codice_inail;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->controllo_inail != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'controllo_inail');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'controllo_inail')
                        ->update(['field_value' => $request->controllo_inail]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "controllo_inail";
                $pdfdata->field_value= $request->controllo_inail;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->provincia_cciaa != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'provincia_cciaa');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'provincia_cciaa')
                        ->update(['field_value' => $request->provincia_cciaa]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "provincia_cciaa";
                $pdfdata->field_value= $request->provincia_cciaa;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->numero_cciaa != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'numero_cciaa');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'numero_cciaa')
                        ->update(['field_value' => $request->numero_cciaa]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "numero_cciaa";
                $pdfdata->field_value= $request->numero_cciaa;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->data_iscrizione != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'data_iscrizione');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'data_iscrizione')
                        ->update(['field_value' => $request->data_iscrizione]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "data_iscrizione";
                $pdfdata->field_value= $request->data_iscrizione;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->numero_dipendenti != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'numero_dipendenti');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'numero_dipendenti')
                        ->update(['field_value' => $request->numero_dipendenti]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "numero_dipendenti";
                $pdfdata->field_value= $request->numero_dipendenti;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->codice_sdi != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'codice_sdi');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'codice_sdi')
                        ->update(['field_value' => $request->codice_sdi]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "codice_sdi";
                $pdfdata->field_value= $request->codice_sdi;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->fatturato_annoprima != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'fatturato_annoprima');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'fatturato_annoprima')
                        ->update(['field_value' => $request->fatturato_annoprima]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "fatturato_annoprima";
                $pdfdata->field_value= $request->fatturato_annoprima;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->redditi_annoprima != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'redditi_annoprima');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'redditi_annoprima')
                        ->update(['field_value' => $request->redditi_annoprima]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "redditi_annoprima";
                $pdfdata->field_value= $request->redditi_annoprima;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->tipologia_contratto != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'tipologia_contratto');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'tipologia_contratto')
                        ->update(['field_value' => $request->tipologia_contratto]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "tipologia_contratto";
                $pdfdata->field_value= $request->tipologia_contratto;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->tempo != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'tempo');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'tempo')
                        ->update(['field_value' => $request->tempo]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "tempo";
                $pdfdata->field_value= $request->tempo;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->mansoine != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'mansoine');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'mansoine')
                        ->update(['field_value' => $request->mansoine]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "mansoine";
                $pdfdata->field_value= $request->mansoine;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->mesi_lavoro != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'mesi_lavoro');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'mesi_lavoro')
                        ->update(['field_value' => $request->mesi_lavoro]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "mesi_lavoro";
                $pdfdata->field_value= $request->mesi_lavoro;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->orario_settimanale != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'orario_settimanale');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'orario_settimanale')
                        ->update(['field_value' => $request->orario_settimanale]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "orario_settimanale";
                $pdfdata->field_value= $request->orario_settimanale;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->livello_categoria != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'livello_categoria');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'livello_categoria')
                        ->update(['field_value' => $request->livello_categoria]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "livello_categoria";
                $pdfdata->field_value= $request->livello_categoria;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->indirizzo_lav != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'indirizzo_lav');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'indirizzo_lav')
                        ->update(['field_value' => $request->indirizzo_lav]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "indirizzo_lav";
                $pdfdata->field_value= $request->indirizzo_lav;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->civico_lav != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'civico_lav');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'civico_lav')
                        ->update(['field_value' => $request->civico_lav]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "civico_lav";
                $pdfdata->field_value= $request->civico_lav;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->cap_lav != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'cap_lav');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'cap_lav')
                        ->update(['field_value' => $request->cap_lav]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "cap_lav";
                $pdfdata->field_value= $request->cap_lav;
                $pdfdata->save();
            }
        }
        //Flussi 2023
        if($request->citta_lav != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'citta_lav');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'citta_lav')
                        ->update(['field_value' => $request->citta_lav]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "citta_lav";
                $pdfdata->field_value= $request->citta_lav;
                $pdfdata->save();
            }
        }

        //Flussi 2023
        if($request->provincia_lav != ""){
            $recored_exist = Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'provincia_lav');
            if(($recored_exist->count()> 0)){
                Pdfdata::where('file_id', $request->file_id_no)->where('field_name', 'provincia_lav')
                        ->update(['field_value' => $request->provincia_lav]);
            }else{
                $pdfdata = new Pdfdata();
                $pdfdata->file_id = $request->file_id_no;
                $pdfdata->field_name = "provincia_lav";
                $pdfdata->field_value= $request->provincia_lav;
                $pdfdata->save();
            }
        }

        return redirect()->back();
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
        $files = Invoice::select('invoices.id', 'invoices.price', 'invoices.file_id', 'invoices.customer_id', 
                                'customers.taxid', 'customers.firstname as customer','invoices.shop_name as shop',
                                'services.service', 'invoices.status', 'invoices.lawyer_id', 'invoices.lawyer_price')
                                    ->join('customers', 'invoices.customer_id', '=', 'customers.id')
                                    ->join('services', 'invoices.service_id', '=', 'services.id')
                                    ->where('invoices.file_id', $file_id)
                                    ->get();
        $pdfdata['anno'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'anno')->get();
        $pdfdata['rif'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'rif')->get();
        $pdfdata['registration_no'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'registration_no')->get();
        $pdfdata['registration_date'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'registration_date')->get();
        $pdfdata['common_chamber_of_commerce'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'common_chamber_of_commerce')->get();
        $pdfdata['indirizzo'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'indirizzo')->get();
        $pdfdata['civico'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'civico')->get();
        $pdfdata['cap'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'cap')->get();
        $pdfdata['citta'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'citta')->get();
        $pdfdata['provincia'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'provincia')->get();
        $pdfdata['partita_iva'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'partita_iva')->get();
        $pdfdata['codice_fiscale'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'codice_fiscale')->get();
        $pdfdata['codice_ateco'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'codice_ateco')->get();
        $pdfdata['tipo_attivita'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'tipo_attivita')->get();
        $pdfdata['reddito'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'reddito')->get();
        return view('admin.file_view', compact('comments', 'attachments', 'files', 'pdfdata', 'title'));
    }

    public function FileEdit($file_id)
    {
        $title = "Edit File";
        $comments = DB::table('comments')->where('file_id', $file_id)->get();
        $attachments = DB::table('attachments')->where('file_id', $file_id)->get();
        $files = Invoice::select('invoices.id', 'invoices.price', 'invoices.file_id', 'invoices.customer_id', 
                                'customers.taxid', 'customers.firstname as customer','invoices.shop_name as shop',
                                'services.service', 'invoices.status', 'invoices.lawyer_id', 'invoices.lawyer_price')
                                    ->join('customers', 'invoices.customer_id', '=', 'customers.id')
                                    ->join('services', 'invoices.service_id', '=', 'services.id')
                                    ->where('invoices.file_id', $file_id)
                                    ->get();
        $pdfdata['anno'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'anno')->get();
        $pdfdata['rif'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'rif')->get();
        $pdfdata['registration_no'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'registration_no')->get();
        $pdfdata['registration_date'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'registration_date')->get();
        $pdfdata['common_chamber_of_commerce'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'common_chamber_of_commerce')->get();
        $pdfdata['indirizzo'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'indirizzo')->get();
        $pdfdata['civico'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'civico')->get();
        $pdfdata['cap'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'cap')->get();
        $pdfdata['citta'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'citta')->get();
        $pdfdata['provincia'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'provincia')->get();
        $pdfdata['partita_iva'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'partita_iva')->get();
        $pdfdata['codice_fiscale'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'codice_fiscale')->get();
        $pdfdata['codice_ateco'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'codice_ateco')->get();
        $pdfdata['tipo_attivita'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'tipo_attivita')->get();
        $pdfdata['reddito'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'reddito')->get();

        //Flussi
        $pdfdata['nome'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'nome')->get();
        $pdfdata['cognome'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'cognome')->get();
        $pdfdata['luogo_nascita'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'luogo_nascita')->get();
        $pdfdata['data_nascita'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'data_nascita')->get();
        $pdfdata['sesso'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'sesso')->get();
        $pdfdata['cittadinanza'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'cittadinanza')->get();
        $pdfdata['paese_residenza'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'paese_residenza')->get();
        $pdfdata['ragione_sociale'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'ragione_sociale')->get();
        $pdfdata['cf_azienda'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'cf_azienda')->get();
        $pdfdata['flussi_partita_iva'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'flussi_partita_iva')->get();
        $pdfdata['indirizzo_sede'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'indirizzo_sede')->get();
        $pdfdata['citta_sede'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'citta_sede')->get();
        $pdfdata['provincia_sede'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'provincia_sede')->get();
        $pdfdata['cap_sede'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'cap_sede')->get();
        $pdfdata['indirizzo_operativa'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'indirizzo_operativa')->get();
        $pdfdata['citta_operativa'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'citta_operativa')->get();
        $pdfdata['provincia_operativa'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'provincia_operativa')->get();
        $pdfdata['cap_operativa'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'cap_operativa')->get();
        $pdfdata['matricola_inps'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'matricola_inps')->get();
        $pdfdata['sede_inail'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'sede_inail')->get();
        $pdfdata['codice_inail'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'codice_inail')->get();
        $pdfdata['controllo_inail'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'controllo_inail')->get();
        $pdfdata['provincia_cciaa'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'provincia_cciaa')->get();
        $pdfdata['numero_cciaa'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'numero_cciaa')->get();
        $pdfdata['data_iscrizione'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'data_iscrizione')->get();
        $pdfdata['numero_dipendenti'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'numero_dipendenti')->get();
        $pdfdata['codice_sdi'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'codice_sdi')->get();
        $pdfdata['fatturato_annoprima'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'fatturato_annoprima')->get();
        $pdfdata['redditi_annoprima'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'redditi_annoprima')->get();
        $pdfdata['tipologia_contratto'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'tipologia_contratto')->get();
        $pdfdata['tempo'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'tempo')->get();
        $pdfdata['mansoine'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'mansoine')->get();
        $pdfdata['mesi_lavoro'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'mesi_lavoro')->get();
        $pdfdata['orario_settimanale'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'orario_settimanale')->get();
        $pdfdata['livello_categoria'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'livello_categoria')->get();
        $pdfdata['indirizzo_lav'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'indirizzo_lav')->get();
        $pdfdata['civico_lav'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'civico_lav')->get();
        $pdfdata['cap_lav'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'cap_lav')->get();
        $pdfdata['citta_lav'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'citta_lav')->get();
        $pdfdata['provincia_lav'] = Pdfdata::select('field_value')->where('file_id', $file_id)->where('field_name', 'provincia_lav')->get();

        $user_type = Auth::user()->user_type;
        if(($files[0]->status == "Completed" || $files[0]->status == "Cancelled") && $user_type != 'admin')
            return redirect()->back();
        return view('admin.file_edit', compact('comments', 'attachments', 'files', 'pdfdata' , 'title'));
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
        //return redirect()->back()->with($notification);
        return response()->json(['success' => true]);
    }

    public function AssignFiles(Request $request){

        $fileids = preg_replace('/\s+/', '', $request->fileids);
        $fileidsArray = explode(',', $fileids);
        $isAllNumeric = true;
        foreach($fileidsArray as $fileid){
            if(!is_numeric($fileid)){
                $isAllNumeric = false;
            }
        }
        if($isAllNumeric){
            $user_type = User::select('user_type')->where('id', $request->assign_user_id)->first();
            if($user_type->user_type == 'lawyer')
                DB::table('invoices')->whereIn('file_id', $fileidsArray)->update(['lawyer_id' => (int)$request->assign_user_id]);
            else
                DB::table('invoices')->whereIn('file_id', $fileidsArray)->update(['user_id' => (int)$request->assign_user_id]);
            $notification = array(
                'message' => 'File assigned successfully', 
                'alert-type' => 'success'
            );
        }else{
            $notification = array(
                'message' => 'Some file id is not a number', 
                'alert-type' => 'error'
            );
        }
        return redirect()->back()->with($notification);
    }

    public function GetFilterValue(Request $request){
        $selectedValue = $request->input('value');
        if($selectedValue == "shop"){
            $data = User::select('shop_name')->distinct()->get();
        }else if($selectedValue == "service"){
            $data = Service::select('service')->distinct()->get();
        }else if($selectedValue == "status"){
            $data = Invoice::select('status')->distinct()->get();
        }

        return response()->json($data);
    }

}
