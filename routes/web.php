<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[DashboardController::class,'index'] );
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
Route::resource('/profiles' , App\Http\Controllers\ProfilesController::class);
// เคมี
Route::post('/confirmDelProfile' , [App\Http\Controllers\ProfilesController::class , 'confirmDelProfile']);
Route::resource('/chemicalgroups' , App\Http\Controllers\ChemicalGroupController::class);
Route::post('/confirmDelChemicalGroup' , [App\Http\Controllers\ChemicalGroupController::class , 'confirmDelChemicalGroup']);
Route::post('/getData-ChemicalGroup' , [App\Http\Controllers\ChemicalGroupController::class , 'getDataChemicalGroup']);
Route::post('/confirmDelChemicalFuntion' , [App\Http\Controllers\ChemicalGroupController::class , 'confirmDelChemicalFuntion']);
Route::resource('/chemicallists' , App\Http\Controllers\ChemicalListController::class);
Route::post('/confirmDelChemical' , [App\Http\Controllers\ChemicalListController::class , 'confirmDelChemical']);
Route::get('/chemical/functions/{group_id}', [App\Http\Controllers\ChemicalListController::class, 'getFunctions']);
// เคมี

// ทั่วไป
Route::resource('/countrys' , App\Http\Controllers\OtherCountryController::class);
Route::resource('/provinces' , App\Http\Controllers\OtherProvinceController::class);
Route::resource('/districts' , App\Http\Controllers\OtherDistrictController::class);
Route::resource('/sub-districts' , App\Http\Controllers\OtherSubDistrictController::class);
// ทั่วไป

// บัญชี
Route::resource('/companys' , App\Http\Controllers\AccCompanyController::class);
Route::resource('/currencys' , App\Http\Controllers\AccCurrencyController::class);
Route::resource('/periods' , App\Http\Controllers\AccPeriodController::class);
Route::resource('/typevats' , App\Http\Controllers\AccTypevatController::class);
// บัญชี

// ลูกค้า
Route::resource('/customergroups' , App\Http\Controllers\ArCustomerGroupController::class);
Route::resource('/customerlists' , App\Http\Controllers\ArCustomerListController::class);
Route::get('/get-districts/{province_id}', [App\Http\Controllers\ArCustomerListController::class, 'getDistricts']);
Route::get('/get-subdistricts/{district_id}', [App\Http\Controllers\ArCustomerListController::class, 'getSubDistricts']);
// ลูกค้า

//ผู้จำหน่าย
Route::resource('/vendorgroups' , App\Http\Controllers\ApVendorGroupController::class);
Route::resource('/vendorlists' , App\Http\Controllers\ApVendorListController::class);
//ผู้จำหน่าย

//เครื่องวัดมือ
Route::resource('/calibrationcategorys' , App\Http\Controllers\CalibrationCategoryController::class);
Route::resource('/calibrationgroups' , App\Http\Controllers\CalibrationGroupController::class);
Route::resource('/calibrationtypes' , App\Http\Controllers\CalibrationTypeController::class);
Route::resource('/calibrationlists' , App\Http\Controllers\CalibrationListController::class);
Route::get('/calibration/get-last-running', [App\Http\Controllers\CalibrationListController::class, 'getLastRunning'])->name('calibration.getLastRunning');
//เครื่องวัดมือ

// สินค้า
Route::resource('/productgroups' , App\Http\Controllers\WhProductGroupController::class);
Route::resource('/productlists' , App\Http\Controllers\WhProductListController::class);
Route::resource('/producttypes' , App\Http\Controllers\WhProductTypeController::class);
Route::resource('/productunits' , App\Http\Controllers\WhProductUnitController::class);
Route::get('/product/get-last-running', [App\Http\Controllers\WhProductListController::class, 'getLastRunning'])->name('product.getLastRunning');
// สินค้า

// คลังสินค้า
Route::resource('/warehouses' , App\Http\Controllers\WhWarehouseListController::class);
Route::resource('/issuestocks' , App\Http\Controllers\WhIssueStockListController::class);
Route::get('/issuestock/runno', [App\Http\Controllers\WhIssueStockListController::class, 'runNo'])->name('issuestock.runno');
Route::get('issuestock/products-by-warehouse', [App\Http\Controllers\WhIssueStockListController::class, 'getProductsByWarehouse'])->name('issuestock.productsByWarehouse');
Route::post('/CancelIssueStockDoc' , [App\Http\Controllers\WhIssueStockListController::class , 'CancelIssueStockDoc']);
Route::post('/CancelIssueStockList' , [App\Http\Controllers\WhIssueStockListController::class , 'CancelIssueStockList']);
Route::resource('/returnstocks' , App\Http\Controllers\WhReturnStockListController::class);
Route::get('/returnstock/runno', [App\Http\Controllers\WhReturnStockListController::class, 'runNo'])->name('returnstock.runno');
Route::get('returnstock/items', [App\Http\Controllers\WhReturnStockListController::class, 'getItems'])->name('returnstock.items');
Route::post('/CancelReturnStockDoc' , [App\Http\Controllers\WhReturnStockListController::class , 'CancelReturnStockDoc']);
Route::resource('/adjuststocks' , App\Http\Controllers\WhAdjustStockListController::class);
Route::get('/adjuststock/runno', [App\Http\Controllers\WhAdjustStockListController::class, 'runNo'])->name('adjuststock.runno');
Route::get('adjuststock/get-stock', [App\Http\Controllers\WhAdjustStockListController::class, 'getStock'])->name('adjuststock.getstock');
Route::post('/CancelAdjustStockDoc' , [App\Http\Controllers\WhAdjustStockListController::class , 'CancelAdjustStockDoc']);
Route::post('/CancelAdjustStockList' , [App\Http\Controllers\WhAdjustStockListController::class , 'CancelAdjustStockList']);
// คลังสินค้า

// ขาย
Route::resource('/requestorders' , App\Http\Controllers\ArRequestOrderListController::class);
Route::get('/requestorder/runno', [App\Http\Controllers\ArRequestOrderListController::class, 'runNo'])->name('requestorder.runno');
Route::post('/CancelRequestOrderDoc' , [App\Http\Controllers\ArRequestOrderListController::class , 'CancelRequestOrderDoc']);
Route::resource('/quotations' , App\Http\Controllers\ArQuotationListController::class);
Route::get('/quotation/runno', [App\Http\Controllers\ArQuotationListController::class, 'runNo'])->name('quotation.runno');
Route::get('/customer/address-text', [App\Http\Controllers\ArQuotationListController::class, 'addressText'])->name('customer.addressText');
Route::post('/CancelQuotationsDoc' , [App\Http\Controllers\ArQuotationListController::class , 'CancelQuotationsDoc']);
Route::get('quotations/{id}/print',[App\Http\Controllers\ArQuotationListController::class, 'print'])->name('quotations.print');
Route::resource('/invoices' , App\Http\Controllers\ArInvoiceListController::class);
Route::get('/invoice/runno', [App\Http\Controllers\ArInvoiceListController::class, 'runNo'])->name('invoice.runno');
Route::get('quotation/items', [App\Http\Controllers\ArInvoiceListController::class, 'getItems'])->name('quotation.items');
Route::post('/CancelInvoicesDoc' , [App\Http\Controllers\ArInvoiceListController::class , 'CancelInvoicesDoc']);
Route::get('invoices/{id}/print', [App\Http\Controllers\ArInvoiceListController::class, 'print'])->name('invoices.print');
Route::resource('/saleorders' , App\Http\Controllers\ArSaleOrderListController::class);
Route::get('/saleorder/runno', [App\Http\Controllers\ArSaleOrderListController::class, 'runNo'])->name('saleorder.runno');
Route::post('/CancelSaleorderDoc' , [App\Http\Controllers\ArSaleOrderListController::class , 'CancelSaleorderDoc']);
Route::get('saleorders/{id}/print', [App\Http\Controllers\ArSaleOrderListController::class,'print'])->name('saleorders.print');
// ขาย

//จัดซื้อ
Route::resource('/purchaserequests' , App\Http\Controllers\ApPurchaseRequestListController::class);
Route::get('/purchaserequest/runno', [App\Http\Controllers\ApPurchaseRequestListController::class, 'runNo'])->name('purchaserequest.runno');
Route::post('/CancelPurchaseRequestDoc' , [App\Http\Controllers\ApPurchaseRequestListController::class , 'CancelPurchaseRequestDoc']);
Route::post('/CancelPurchaseRequestList' , [App\Http\Controllers\ApPurchaseRequestListController::class , 'CancelPurchaseRequestList']);
Route::resource('/purchaseorders' , App\Http\Controllers\ApPurchaseOrderListController::class);
Route::get('/purchaseorder/runno', [App\Http\Controllers\ApPurchaseOrderListController::class, 'runNo'])->name('purchaseorder.runno');
Route::get('/vendor/address-text', [App\Http\Controllers\ApPurchaseOrderListController::class, 'addressText'])->name('vendor.addressText');
Route::post('/CancelPurchaseOrderDoc' , [App\Http\Controllers\ApPurchaseOrderListController::class , 'CancelPurchaseOrderDoc']);
Route::post('/CancelPurchaseOrderList' , [App\Http\Controllers\ApPurchaseOrderListController::class , 'CancelPurchaseOrderList']);
Route::get('/purchaseorders/{id}/print', [App\Http\Controllers\ApPurchaseOrderListController::class, 'print'])->name('purchaseorders.print');
Route::resource('/purchasereceives' , App\Http\Controllers\ApPurchaseReceiveListController::class);
Route::get('/purchasereceive/runno', [App\Http\Controllers\ApPurchaseReceiveListController::class, 'runNo'])->name('purchasereceive.runno');
Route::get('purchase/items', [App\Http\Controllers\ApPurchaseReceiveListController::class, 'getItems'])->name('purchase.items');
Route::post('/CancelPurchaseReceiveDoc' , [App\Http\Controllers\ApPurchaseReceiveListController::class , 'CancelPurchaseReceiveDoc']);
//จัดซื้อ