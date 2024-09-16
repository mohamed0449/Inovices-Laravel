<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Customers_Report;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceArchiveController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Invoices_Report;
use App\Http\Controllers\InvoicesAttachmentsController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\UsersController;
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

Route::get('/home', function () {
    return view('home');
})->middleware(['auth'])->name('home');

Route::get('/home', [HomeController::class,'index'])->name('home');

require __DIR__.'/auth.php';

Route::resource('invoices',InvoiceController::class);

Route::resource('sections',SectionsController::class);

Route::resource('products',ProductsController::class);

Route::resource('InvoiceAttachments',InvoicesAttachmentsController::class);

Route::get('/section/{id}',[InvoiceController::class,"getproducts"]);

Route::get('/InvoicesDetails/{id}',[InvoicesDetailsController::class,"edit"]);

Route::get('View_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class,"open_file"]);

Route::get('download/{invoice_number}/{file_name}', [InvoicesDetailsController::class,"get_file"]);

Route::post('delete_file', [InvoicesDetailsController::class,"destroy"])->name('delete_file');

Route::get('/edit_invoice/{id}', [InvoiceController::class,"edit"]);

Route::get('/Status_show/{id}', [InvoiceController::class,"show"])->name('Status_show');

Route::post('/Status_Update/{id}', [InvoiceController::class,"Status_Update"])->name('Status_Update');

Route::get('Invoice_Paid', [InvoiceController::class,"Invoice_Paid"]);

Route::get('Invoice_UnPaid', [InvoiceController::class,"Invoice_UnPaid"]);

Route::get('Invoice_Partial', [InvoiceController::class,"Invoice_Partial"]);

Route::resource('Archive', InvoiceArchiveController::class);

Route::get('Print_invoice/{id}', [InvoiceController::class,"Print_invoice"]);

Route::get('export_invoices', [InvoiceController::class, 'export']);


Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RolesController::class);
    Route::resource('users', UsersController::class);
});

Route::get('invoices_report', [Invoices_Report::class,'index']);

Route::post('Search_invoices', [Invoices_Report::class,'Search_invoices']);

Route::get('customers_report', [Customers_Report::class,'index'])->name('customers_report');

Route::post('Search_customers', [Customers_Report::class,'Search_customers']);

Route::get('MarkAsRead_all',[InvoiceController::class,"MarkAsRead_all"])->name("MarkAsRead_all");

Route::get('unreadNotifications',[InvoiceController::class,"unreadNotifications"])->name("unreadNotifications");

Route::get('unreadNotifications_count',[InvoiceController::class,"unreadNotifications_count"])->name("unreadNotifications_count");

Route::get('/{page}', [AdminController::class,'index']);