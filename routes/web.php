<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Customers_Report;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\InvoiceArchiveController; // Add this line
use App\Http\Controllers\Invoices_Report;
use App\Http\Controllers\PrdsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\SectionsController;

// Auth::routes(['register' => false ,]);
Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', function () {
    return view('home');
})->middleware(['auth'])->name('home');

Route::get('/home', [HomeController::class, 'index'])->name('home');
require __DIR__ . '/auth.php';

Route::resource('invoices', InvoicesController::class);
Route::resource('sections', SectionsController::class);
Route::resource('products', prdsController::class);
Route::resource('InvoiceAttachments', InvoiceAttachmentsController::class);
Route::resource('Archive', InvoiceArchiveController::class);

Route::get('/section/{id}', [InvoicesController::class, 'getproducts']);
Route::get('/InvoicesDetails/{id}', [InvoicesDetailsController::class, 'edit'])->name('InvoicesDetails.edit');

Route::get('View_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class,'open_file']);
Route::get('download/{invoice_number}/{file_name}', [InvoicesDetailsController::class,'get_file']);
Route::post('delete_file', [InvoicesDetailsController::class, 'destroy'])->name('delete_file');
Route::get('/edit_invoice/{id}', [InvoicesController::class,'edit']);
Route::get('/Status_show/{id}', [InvoicesController::class, 'show'])->name('Status_show');
Route::post('/Status_Update/{id}', [InvoicesController::class,'Status_Update'])->name('Status_Update');

Route::get('Invoice_Paid', [InvoicesController::class,'Invoice_Paid']);
Route::get('Invoice_UnPaid', [InvoicesController::class,'Invoice_UnPaid']);
Route::get('Invoice_Partial', [InvoicesController::class,'Invoice_Partial']);

Route::get('Print_invoice/{id}', [InvoicesController::class,'Print_invoice']);

Route::get('export_invoices', [InvoicesController::class,'export']);

Route::group(['middleware' => ['auth']], function () {

    Route::resource('roles', RoleController::class);

    Route::resource('users', UserController::class);

});

Route::get('invoices_report', [Invoices_Report::class, 'index']);

Route::post('Search_invoices', [Invoices_Report::class, 'Search_invoices']);

Route::get('customers_report', [Customers_Report::class, 'index'])->name('customers_report');

Route::post('Search_customers', [Customers_Report::class, 'Search_customers']);

Route::post('MarkAsRead', [InvoicesController::class, "MarkAsRead"])->name("MarkAsRead");

Route::get('MarkAsRead_all', [InvoicesController::class, "MarkAsRead_all"])->name("MarkAsRead_all");

Route::get('unreadNotifications', [InvoicesController::class, "unreadNotifications"])->name("unreadNotifications");

Route::get('unreadNotifications_count', [InvoicesController::class, "unreadNotifications_count"])->name("unreadNotifications_count");

Route::get('/{page}', [AdminController::class, 'index']);


