<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Customer;

class ClientController extends Controller
{
    public function ClientDataTable(): View

    {
        $title = "Users";
        $users = DB::table('users')->get();
        return view('admin.client_data_table', compact('users', 'title'));
    }

    public function NewClientData(): View

    {
        $title = "New User";
        return view('admin.client_new', compact('title'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Company  $company
    * @return \Illuminate\Http\Response
    */
    public function EditClientData($id): View
    {
        $title = "Edit User";
        $user = DB::table('users')->where('id', $id)->first();
        return view('admin.client_edit',compact('user', 'title'));
    }

    public function StoreClientData(Request $request): View
    {
        $validateData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'usertype' => ['required', 'string', 'max:255', Rule::in(['admin','user'])],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if(empty($request->new_shop) && $request->shop_name != 'create_new')
            {
                $new_shop_name =  $request->shop_name;
            }else{ 
                $new_shop_name =  $request->new_shop;
            }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'user_type' => $request->usertype,
            'password' => Hash::make($request->password),
            'shop_name' => $new_shop_name,
        ]);

        return $this->ClientDataTable();
    }

     /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Company  $company
    * @return \Illuminate\Http\Response
    */
    public function UpdateClientData(Request $request, $id): View
    {
        $validateData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'usertype' => ['required', 'string', 'max:255', Rule::in(['admin','user'])],
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->user_type = $request->usertype;
        $user->shop_name = $request->shop_name;
        $user->save();

        return $this->ClientDataTable();
    }

    public function DeleteClientData($id)
    {
        $customer = DB::table('users')->where('id', $id)->delete();
        
        return $this->ClientDataTable();
    }

}
