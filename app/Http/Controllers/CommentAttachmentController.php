<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Comment;
use App\Models\Attachment;

class CommentAttachmentController extends Controller
{
    public function CommentAttachment(): View
    {
        $comments = DB::table('comments')->where('file_id', "12650304")->get();
        $attachments = DB::table('attachments')->where('file_id', "12650304")->get();
        return view('admin.comments_attachments', compact('comments', 'attachments'));
    }

    public function PostComment(Request $request)
    {
        if(empty($request->comment)){
            $notification = array(
                'message' => 'Comment is empty! Not Saved!', 
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        $username = Auth::user()->username;
        $file_id = "12650304";
        
        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->file_id = $file_id;
        $comment->username = $username;
        $comment->save();

        $notification = array(
            'message' => 'New comment added successfully', 
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function UploadFile(Request $request)
    {
        $attachment = new Attachment();
        $attachment->username = Auth::user()->username;
        $attachment->category = $request->category;
        $attachment->file_id = "12650304";

        if ($request->file('upload_file')) {
            $file = $request->file('upload_file');
 
            $filename = $file->getClientOriginalName();
            $filename = str_replace(' ', '_', $filename);
            $file->move(public_path('upload/file_attachments/12650304'),$filename);
            $attachment['file_name'] = $filename;

            $attachment->save();
            $notification = array(
                'message' => 'New file added successfully', 
                'alert-type' => 'success'
            );
         }else{
            $notification = array(
                'message' => 'No file added!', 
                'alert-type' => 'info'
            );
         }
        
        return redirect()->route('comments.attachments')->with($notification);
    }

    
}
