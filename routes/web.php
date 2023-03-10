<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CommentAttachmentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\SettingsController;
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
    Route::get('/customer/search', [CustomerController::class, 'CustomerSearch'])->name('customer.search');
    Route::post('/customer/store', [CustomerController::class, 'StoreCustomerData'])->name('customer.store');
    Route::post('/customer/update/{id}', [CustomerController::class, 'UpdateCustomerData'])->name('customer.update');
    Route::get('/customer/edit/{id}', [CustomerController::class, 'EditCustomerData'])->name('customer.edit');
    Route::get('/customer/show/{id}', [CustomerController::class, 'ShowCustomerData'])->name('customer.show');
    Route::get('/customer/delete/{id}', [CustomerController::class, 'DeleteCustomerData'])->name('customer.delete')->middleware('admin');

});

Route::middleware('auth' , 'admin')->group(function(){
    Route::get('/client/table', [ClientController::class, 'ClientDataTable'])->name('client.table');
    Route::get('/client/new', [ClientController::class, 'NewClientData'])->name('client.new');
    Route::post('/client/store', [ClientController::class, 'StoreClientData'])->name('client.store');
    Route::post('/client/update/{id}', [ClientController::class, 'UpdateClientData'])->name('client.update');
    Route::get('/client/edit/{id}', [ClientController::class, 'EditClientData'])->name('client.edit');
    Route::get('/client/show', [ClientController::class, 'ShowClientData'])->name('client.show');
    Route::get('/client/delete/{id}', [ClientController::class, 'DeleteClientData'])->name('client.delete');
});

Route::middleware('auth')->group(function(){
    Route::post('/post/comment', [CommentAttachmentController::class, 'PostComment'])->name('post.comment');
    Route::post('/upload/file', [CommentAttachmentController::class, 'UploadFile'])->name('upload.file');
    Route::post('/delete/file', [CommentAttachmentController::class, 'DeleteFile'])->name('delete.file');
    Route::post('/delete/comment', [CommentAttachmentController::class, 'DeleteComment'])->name('delete.comment');
    Route::post('/update/comment', [CommentAttachmentController::class, 'UpdateComment'])->name('update.comment');
    Route::get('/download/file/{id}', [CommentAttachmentController::class, 'DownloadFile'])->name('download.file');
});

Route::middleware('auth', 'admin')->group(function(){
    Route::get('/create/category', [ServiceCategoryController::class, 'CreateCategory'])->name('create.category');
    Route::get('/show/category', [ServiceCategoryController::class, 'ShowCategory'])->name('show.category');
    Route::post('/add/category', [ServiceCategoryController::class, 'AddCategory'])->name('add.category');
    Route::post('/add/service', [ServiceCategoryController::class, 'AddService'])->name('add.service');
    Route::post('/add/service_category', [ServiceCategoryController::class, 'AddServiceCategory'])->name('add.service_category');
});

Route::middleware('auth')->group(function(){
    Route::post('/file/store', [FileController::class, 'FileStore'])->name('file.store');
    Route::get('/file/data', [FileController::class, 'FileDataTable'])->name('file.data');
    Route::get('/file/edit/{id}', [FileController::class, 'FileEdit'])->name('file.edit');
    Route::get('/file/delete/{id}', [FileController::class, 'FileDelete'])->name('file.delete')->middleware('admin');
    Route::get('/file/show/{id}', [FileController::class, 'FileShow'])->name('file.show');
    Route::get('/load/services', [ServiceCategoryController::class, 'getServices'])->name('load.services');
    Route::get('/load/customer', [CustomerController::class, 'GetCustomerInfo'])->name('customer.info');
    Route::post('/update/status/price', [FileController::class, 'UpdateFileStatusAndPrice'])->name('update.status.price');

    Route::get('/movement/data', [FileController::class, 'MovementDataTable'])->name('movement.data');
});

Route::middleware('auth' , 'admin')->group(function(){
    Route::get('/create/settings', [SettingsController::class, 'CreateSettings'])->name('create.settings');
    Route::post('/add/upload_type', [SettingsController::class, 'AddUploadType'])->name('add.upload_type');
});

Route::middleware('auth' , 'admin')->group(function(){
    Route::get('/reset/password', [AdminController::class, 'ViewResetPassword'])->name('reset.password');
    Route::post('/store/new_password', [AdminController::class, 'ResetPassword'])->name('store.new_password');
});

Route::middleware('auth' , 'admin')->group(function(){
    Route::get('/card/info', [DashboardController::class, 'CardInfo'])->name('card.info');
});

require __DIR__.'/auth.php';
