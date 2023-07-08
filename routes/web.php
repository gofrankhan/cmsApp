<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CommentAttachmentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FileController_simple;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\BroadcastMessageController;
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

Route::middleware('auth', 'verified')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/dashboard', [DashboardController::class, 'CreateTable'])->name('dashboard');
    // Route::get('/dashboard/user', [DashboardController::class, 'CreateTableUser'])->name('dashboard.user');
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
    Route::get('/delete/file/{id}', [CommentAttachmentController::class, 'DeleteFile'])->name('delete.file');
    Route::post('/delete/comment', [CommentAttachmentController::class, 'DeleteComment'])->name('delete.comment');
    Route::post('/update/comment', [CommentAttachmentController::class, 'UpdateComment'])->name('update.comment');
    Route::post('/download/file/{id}', [CommentAttachmentController::class, 'DownloadFile'])->name('download.file');
});

Route::middleware('auth', 'admin')->group(function(){
    Route::get('/create/category', [ServiceCategoryController::class, 'CreateCategory'])->name('create.category');
    Route::get('/show/category', [ServiceCategoryController::class, 'ShowCategory'])->name('show.category');
    Route::post('/add/category', [ServiceCategoryController::class, 'AddCategory'])->name('add.category');
    Route::post('/add/service', [ServiceCategoryController::class, 'AddService'])->name('add.service');
    Route::post('/add/service_category', [ServiceCategoryController::class, 'AddServiceCategory'])->name('add.service_category');
    Route::get('/load/service/price', [ServiceCategoryController::class, 'getServicePrice'])->name('load.service.price');
    Route::post('/update/service/price', [ServiceCategoryController::class, 'UpdateServicePrice'])->name('update.service.price');
});

Route::middleware('auth')->group(function(){
    Route::post('/file/store', [FileController::class, 'FileStore'])->name('file.store');
    Route::get('/file/data/{type}', [FileController::class, 'FileDataTable'])->name('file.data');
    Route::get('/file/edit/{id}', [FileController::class, 'FileEdit'])->name('file.edit');
    Route::get('/file/delete/{id}', [FileController::class, 'FileDelete'])->name('file.delete')->middleware('admin');
    Route::post('/update/service', [FileController::class, 'UpdateService'])->name('update.service');
    Route::get('/file/show/{id}', [FileController::class, 'FileShow'])->name('file.show');
    Route::post('/get/shop/name', [FileController::class, 'GetShopNameList'])->name('get.shop.name');
    Route::get('/load/customer', [CustomerController::class, 'GetCustomerInfo'])->name('customer.info');
    Route::post('/update/status/price', [FileController::class, 'UpdateFileStatusAndPrice'])->name('update.status.price');

    Route::get('/movement/data', [FileController::class, 'MovementDataTable'])->name('movement.data');
    Route::get('/movement/data/all', [FileController::class, 'MovementDataTableAll'])->name('movement.data.all');
    Route::get('/load/services', [ServiceCategoryController::class, 'getServices'])->name('load.services');
    Route::post('/assign/files', [FileController::class, 'AssignFiles'])->name('assign.files');
});

Route::middleware('auth')->group(function(){
    Route::post('/file/store/simple', [FileController_simple::class, 'FileStore'])->name('file.store.simple');
    Route::get('/file/data/simple/{type}', [FileController_simple::class, 'FileDataTable_simple'])->name('file.data.simple');
    Route::get('/load/table/search', [FileController_simple::class, 'LoadTableSearch_simple'])->name('load.table.search');
    Route::get('/file/edit/simple/{id}', [FileController_simple::class, 'FileEdit'])->name('file.edit.simple');
    Route::get('/file/delete/simple/{file_id}', [FileController_simple::class, 'FileDelete'])->name('file.delete.simple')->middleware('admin');
    Route::post('/update/service/simple', [FileController_simple::class, 'UpdateService'])->name('update.service.simple');
    Route::get('/file/show/simple/{id}', [FileController_simple::class, 'FileShow'])->name('file.show.simple');
    Route::post('/get/shop/name', [FileController::class, 'GetShopNameList'])->name('get.shop.name');
    Route::get('/load/customer/simple', [FileController_simple::class, 'GetCustomerInfo'])->name('customer.info.simple');
    Route::post('/update/status/price/simple', [FileController_simple::class, 'UpdateFileStatusAndPrice'])->name('update.status.price.simple');

    Route::get('/movement/data/simple', [FileController_simple::class, 'MovementDataTable'])->name('movement.data.simple');
    Route::get('/movement/data/all/simple', [FileController_simple::class, 'MovementDataTableAll'])->name('movement.data.all.simple');
    Route::get('/load/services/simple', [ServiceCategoryController::class, 'getServices'])->name('load.services.simple');
    Route::post('/assign/files/simple', [FileController_simple::class, 'AssignFiles'])->name('assign.files.simple');
});

Route::middleware('auth' , 'admin')->group(function(){
    Route::get('/create/settings', [SettingsController::class, 'CreateSettings'])->name('create.settings');
    Route::post('/add/upload_type', [SettingsController::class, 'AddUploadType'])->name('add.upload_type');
});

Route::middleware('auth' , 'admin')->group(function(){
    Route::post('/delete/broadcast/message', [BroadcastMessageController::class, 'DeleteBroadcastMessage'])->name('delete.broadcast.message');
    Route::post('/create/broadcast/message', [BroadcastMessageController::class, 'CreateBroadcastMessage'])->name('create.broadcast.message');
});

Route::middleware('auth' , 'admin')->group(function(){
    Route::get('/reset/password', [AdminController::class, 'ViewResetPassword'])->name('reset.password');
    Route::post('/store/new_password', [AdminController::class, 'ResetPassword'])->name('store.new_password');
});

Route::middleware('auth' , 'admin')->group(function(){
    Route::get('/card/info', [DashboardController::class, 'CardInfo'])->name('card.info');
});

Route::middleware('auth' , 'admin')->group(function(){
    Route::get('/generate/pdf', [PDFController::class, 'generatePDF'])->name('generate.pdf');
    Route::get('/delega/dsu/{id}', [PDFController::class, 'DelegaDSU_PDF'])->name('delega.dsu');
    Route::get('/delega/730/{id}', [PDFController::class, 'Delega730_PDF'])->name('delega.730');
    Route::get('/auto/red/imp/{id}', [PDFController::class, 'Autocertificazione_redditi_impresa_pdf'])->name('auto.red.imp');
    Route::get('/del/tra/dis/{id}', [PDFController::class, 'Delega_Trasmissione_Dichiarazione_dei_Redditi_pdf'])->name('del.tra.dis');

    Route::get('/dichiarazione/redditi', [PDFController::class, 'DICHIARAZIONE_REDDITI_PF'])->name('dichiarazione.redditi');
});

require __DIR__.'/auth.php';
