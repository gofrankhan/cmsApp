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
use App\Models\BroadcastMessage;

class BroadcastMessageController extends Controller
{
    public function DeleteBroadcastMessage(Request $request){
        DB::table('broadcast_messages')
                        ->where('id', $request->message_id)
                        ->delete();
        return redirect()->back();
    }

    public function CreateBroadcastMessage(Request $request){
        $broadcast_message = new BroadcastMessage();
        $broadcast_message->message = $request->message;
        $broadcast_message->save();
        return redirect()->back();
    }
}
