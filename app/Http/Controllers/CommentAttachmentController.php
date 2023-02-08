<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Madnest\Madzipper\Madzipper;
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
        
        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->file_id = $request->file_id;
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
        $attachment->file_id = $request->file_id;

        if ($request->file('upload_file')) {
            $file = $request->file('upload_file');
 
            $filename = $file->getClientOriginalName();
            $filename = str_replace(' ', '_', $filename);
            $file->move(public_path('upload/file_attachments/'.$request->file_id),$filename);
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
        
        return redirect()->back()->with($notification);
    }

    public function DeleteFile(Request $request){
        $files = DB::table('attachments')
                        ->where('file_id', $request->file_id)
                        ->where('file_name', $request->file_name)
                        ->delete();
        
        $file = public_path('upload/file_attachments/'.$request->file_id.'/'.$request->file_name);
        $realPath = realpath($file);
        if ($realPath) {
            File::delete($realPath);
            $notification = array(
                'message' => 'File deleted successfully!', 
                'alert-type' => 'success'
             );
        } else {
            $notification = array(
                'message' => 'File doesnot exist of incorrect path!', 
                'alert-type' => 'warning'
             );
        }
        return redirect()->back()->with($notification);
    }

    public function DeleteComment(Request $request){
        $files = DB::table('comments')
                        ->where('id', $request->id)
                        ->delete();
        
        $notification = array(
            'message' => 'Comment deleted successfully!', 
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function DownloadFile($file_id){
        $disk = Storage::disk('local');
        $fs = $disk->getDriver();
        $zipper = new Madzipper($fs, realpath(public_path('upload/file_attachments/'.$file_id)));
        $zipper->zip($file_id.'.zip');
        return $zipper->download();
    }

    public function UpdateComment(Request $request){
        // $comment = Comment::find($request->id);
        // $comment->comment = $request->content;
        // $comment->save();
        $notification = array(
            'message' => 'Comment updated successfully!', 
            'alert-type' => 'success'
        );
        return redirect()->route('comments.attachments')->with($notification);
    }

    
}
