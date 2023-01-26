<?php

namespace App\Http\Controllers;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function CustomerDataTable(): View

    {
        $username = Auth::user()->username;
        return view('admin.customer_data_table', ['customers' => DB::table('customers')->where('username', $username)->get()]);
    }

    public function NewCustomerData(): View

    {
        return view('admin.customer_new');
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function StoreCustomerData(Request $request)
    {
        
        if(empty($request->taxid)){
            $notification = array(
                'message' => 'Tax ID should not be empty', 
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        $request->validate([
            'taxid' => 'required',
        ]);
        $taxid_count = DB::table('customers')->where('taxid', $request->taxid)->get()->count();
        if($taxid_count > 0){
            $notification = array(
                'message' => 'Tax ID already exists', 
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        
        $username = Auth::user()->username;
        $customer = new Customer();
        $customer->username = $username;
        $customer->taxid = $request->taxid;
        $customer->customertype = $request->customertype;
        $customer->company = $request->company;
        $customer->firstname = $request->firstname;
        $customer->lastname = $request->lastname;
        $customer->telephone = $request->telephone;
        $customer->mobile = $request->mobile;
        $customer->dateofbirth = $request->dateofbirth;
        $customer->citizenship = $request->citizenship;
        $customer->addressline1 = $request->addressline1;
        $customer->addressline2 = $request->addressline2;
        $customer->city = $request->city;
        $customer->region = $request->region;
        $customer->postcode = $request->postcode;
        $customer->save();
        $notification = array(
            'message' => 'Customer data added successfully', 
            'alert-type' => 'success'
        );
        return redirect()->route('customer.data')->with($notification);
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\company  $company
    * @return \Illuminate\Http\Response
    */
    public function ShowCustomerData($id)
    {
        
        $customer = DB::table('customers')->where('id', $id)->first();
        //$customerData = Customer::find($id);
        return view('admin.customer_show',compact('customer'));
    }

      /**
    * Display the specified resource.
    *
    * @param  \App\company  $company
    * @return \Illuminate\Http\Response
    */
    public function DeleteCustomerData($id)
    {
        $customer = DB::table('customers')->where('id', $id)->delete();
        
        return $this->CustomerDataTable();
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Company  $company
    * @return \Illuminate\Http\Response
    */
    public function EditCustomerData($id): View
    {
        $customer = DB::table('customers')->where('id', $id)->first();
        //$customerData = Customer::find($id);
        return view('admin.customer_edit',compact('customer'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\company  $company
    * @return \Illuminate\Http\Response
    */
    public function UpdateCustomerData(Request $request, $id)
    {
        if(empty($request->taxid)){
            $notification = array(
                'message' => 'Tax ID should not be empty', 
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        $request->validate([
            'taxid' => 'required',
        ]);
        
        $username = Auth::user()->username;
        $customer = Customer::find($id);
        $customer->username = $username;
        $customer->taxid = $request->taxid;
        $customer->customertype = $request->customertype;
        $customer->company = $request->company;
        $customer->firstname = $request->firstname;
        $customer->lastname = $request->lastname;
        $customer->telephone = $request->telephone;
        $customer->mobile = $request->mobile;
        $customer->dateofbirth = $request->dateofbirth;
        $customer->citizenship = $request->citizenship;
        $customer->addressline1 = $request->addressline1;
        $customer->addressline2 = $request->addressline2;
        $customer->city = $request->city;
        $customer->region = $request->region;
        $customer->postcode = $request->postcode;
        $customer->save();
        $notification = array(
            'message' => 'Customer data updated successfully', 
            'alert-type' => 'success'
        );
        return redirect()->route('customer.data')->with($notification);
    }

}
