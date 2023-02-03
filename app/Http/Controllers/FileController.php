<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\User;

class FileController extends Controller
{
    public function FileDataTable(): View
    {
        return view('admin.file_data_table');
    }

    public function NewFileData(): View
    {
        return view('admin.file_new');
    }
}
