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

class CategoryController extends Controller
{
    public function CreateCategory(): View

    {
        return view('admin.add_category');
    }
}
