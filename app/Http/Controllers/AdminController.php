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

class AdminController extends Controller
{
    public function Profile(): View
    {
        $title = "Profile";
        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('admin.admin_profile_view',compact('adminData', 'title'));
    } //End Method

    public function ViewResetPassword(): View
    {
        $title = "Reset Password";
        return view('admin.reset_password', compact('title'));
    } //End Method

    public function ResetPassword(Request $request)
    {
        $validateData = $request->validate([
            'username' => 'required',
            'newpassword' => 'required',
            'confirm_password' => 'required|same:newpassword',

        ]);
        $userOld = DB::table('users')->where('username', $request->username)->first();
        $userNew = User::find($userOld->id);
        $userNew->password = bcrypt($request->newpassword);
        $userNew->save();

        session()->flash('message','Password reset successfully');
        return redirect()->back();
    } //End Method



    public function EditProfile(): View
    {
        $title = "Edit Profile";
        $id = Auth::user()->id;
        $editData = User::find($id);
        return view('admin.admin_profile_edit',compact('editData', 'title'));
    } //End Method

    public function StoreProfile(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);

        $data->name = $request->name;
        $data->username = $request->username;
        $data->email = $request->email;

        if ($request->file('profile_image')) {
            $file = $request->file('profile_image');
 
            $filename = date('YmdHis').$file->getClientOriginalName();
            $file->move(('upload/admin_images'),$filename);
            $data['profile_image'] = $filename;
         }
        $data->save();
 
        $notification = array(
            'message' => 'Admin profile updated successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('admin.profile')->with($notification);
    } //End Method

    public function ChangePassword(): View
    {
        $title = "Change Password";
        return view('admin.admin_change_password', compact('title'));
    }

    public function UpdatePassword(Request $request)
    {
        $validateData = $request->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required',
            'confirm_password' => 'required|same:newpassword',

        ]);

        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->oldpassword,$hashedPassword )) {
            $users = User::find(Auth::id());
            $users->password = bcrypt($request->newpassword);
            $users->save();

            session()->flash('message','Password updated successfully');
            return redirect()->back();
        } else{
            session()->flash('message','Old password is not match');
            return redirect()->back();
        }
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return Redirect::to('/login');
    }
}
