<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Comment;
use App\Models\Attachment;

class CommentAttachmentController extends Controller
{
    public function CommentAttachment(): View
    {
        return view('admin.comments_attachments');
    }
}
