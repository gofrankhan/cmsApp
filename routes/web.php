<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CommentAttachmentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ServiceCategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/admin/logout', [AdminController::class, 'destroy'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'Profile'])->name('admin.profile');
    Route::get('/edit/profile', [AdminController::class, 'EditProfile'])->name('edit.profile');
    Route::post('/store/profile', [AdminController::class, 'StoreProfile'])->name('store.profile');
    
    Route::get('/change/password', [AdminController::class, 'ChangePassword'])->name('change.password');
    Route::post('/update/password', [AdminController::class, 'UpdatePassword'])->name('update.password');
});

Route::middleware('auth')->group(function(){
    Route::get('/customer/data', [CustomerController::class, 'CustomerDataTable'])->name('customer.data');
    Route::get('/customer/new', [CustomerController::class, 'NewCustomerData'])->name('customer.new');
    Route::post('/customer/store', [CustomerController::class, 'StoreCustomerData'])->name('customer.store');
    Route::post('/customer/update/{id}', [CustomerController::class, 'UpdateCustomerData'])->name('customer.update');
    Route::get('/customer/edit/{id}', [CustomerController::class, 'EditCustomerData'])->name('customer.edit');
    Route::get('/customer/show/{id}', [CustomerController::class, 'ShowCustomerData'])->name('customer.show');
    Route::get('/customer/delete/{id}', [CustomerController::class, 'DeleteCustomerData'])->name('customer.delete');

});

Route::middleware('auth')->group(function(){
    Route::get('/client/table', [ClientController::class, 'ClientDataTable'])->name('client.table');
    Route::get('/client/new', [ClientController::class, 'NewClientData'])->name('client.new');
    Route::post('/client/store', [ClientController::class, 'StoreClientData'])->name('client.store');
    Route::post('/client/update/{id}', [ClientController::class, 'UpdateClientData'])->name('client.update');
    Route::get('/client/edit/{id}', [ClientController::class, 'EditClientData'])->name('client.edit');
    Route::get('/client/show', [ClientController::class, 'ShowClientData'])->name('client.show');
    Route::get('/client/delete/{id}', [ClientController::class, 'DeleteClientData'])->name('client.delete');
});

Route::middleware('auth')->group(function(){
    Route::get('/comments/attachments', [CommentAttachmentController::class, 'CommentAttachment'])->name('comments.attachments');
    Route::post('/post/comment', [CommentAttachmentController::class, 'PostComment'])->name('post.comment');
    Route::post('/upload/file', [CommentAttachmentController::class, 'UploadFile'])->name('upload.file');
});

Route::middleware('auth')->group(function(){
    Route::get('/create/category', [ServiceCategoryController::class, 'CreateCategory'])->name('create.category');
    Route::get('/show/category', [ServiceCategoryController::class, 'ShowCategory'])->name('show.category');
    Route::post('/add/category', [ServiceCategoryController::class, 'AddCategory'])->name('add.category');
    Route::post('/add/service', [ServiceCategoryController::class, 'AddService'])->name('add.service');
    Route::post('/add/service_category', [ServiceCategoryController::class, 'AddServiceCategory'])->name('add.service_category');
});

Route::middleware('auth')->group(function(){
    Route::get('/file/data', [FileController::class, 'FileDataTable'])->name('file.data');
    Route::get('/load/services', [ServiceCategoryController::class, 'getServices'])->name('load.services');
    Route::get('/load/customer', [CustomerController::class, 'GetCustomerInfo'])->name('customer.info');
});

require __DIR__.'/auth.php';
