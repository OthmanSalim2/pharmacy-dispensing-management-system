<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\MedicineStoreController;
use App\Http\Controllers\PharmacyOrderController;
use App\Http\Controllers\PharmacyStockController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RohtaController;
use App\Http\Controllers\ShowRoshtaController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('albaraka.login');
})->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/', function () {
        return view('albaraka.index');
    })->name('home');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    // Show the edit form
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    // Handle the update request
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

    Route::get('/admin-settings', [AdminController::class, 'index'])->name('admin-settings');
    Route::put('/admin-settings', [AdminController::class, 'update'])->name('admin-update-settings');

    Route::get('/add-user', [UserController::class, 'create'])->name('add-user');
    Route::post('/add-user', [UserController::class, 'store'])->name('store-user');

    Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
    Route::get('/modify-workplace', [UserController::class, 'editWorkplace'])->name('edit-workplace');
    Route::post('/modify-workplace', [UserController::class, 'updateWorkplace'])->name('update-workplace');

    Route::get('/show-warehouses', [StoreController::class, 'index'])->name('show-workhouse');
    Route::get('/show-stock', [StoreController::class, 'mainStock'])->name('show-main-stock');
    Route::get('/show-pharmacy-stock', [StoreController::class, 'pharmacyStock'])->name('pharmacy-stock');

    Route::get('/buy-medicine', [StoreController::class, 'showBuyMedicine'])->name('buy-medicine-stock');
    Route::get('/sale-medicine', [StoreController::class, 'showSaleMedicine'])->name('sale-medicine-stock');

    Route::post('/buy-medicine', [StoreController::class, 'storeMedicine'])->name('store-medicine');
    Route::post('/sale-medicine', [StoreController::class, 'saleMedicine'])->name('sale-medicine');
    Route::get('/medicine-info/{code}', [StoreController::class, 'getMedicineInfo'])->name('medicine-info');

    Route::get('/sales', [StoreController::class, 'showSales'])->name('show-sales');


    Route::get('/show-main-store-pharmacy', [MedicineController::class, 'index'])->name('show-main-store-pharmacy');
    Route::get('/show-pharmacy-orders', [MedicineController::class, 'showPharmacyOrders'])->name('show-pharmacy-orders');
    Route::get('/pharmacy/stock/{code}', [PharmacyStockController::class, 'getMedicine'])
        ->name('pharmacy.stock.get');
    Route::post('/pharmacy-orders/store', [PharmacyOrderController::class, 'store'])->name('pharmacy-orders-store');


    Route::get('/drug-sell', [RohtaController::class, 'index'])->name('drugsell');
    Route::post('/drug-sell/store', [RohtaController::class, 'store'])->name('drugsell.store');
    Route::get('/medicine/by-code', [RohtaController::class, 'getMedicineByCode'])->name('medicine.by-code');
    Route::get('/medicine/search', [RohtaController::class, 'search'])->name('medicine.search'); // ✅ Add this line

    Route::post('/roshta/store', [RohtaController::class, 'storeRohta'])->name('roshta.store');
    Route::post('/roshta/pause', [RohtaController::class, 'pause'])->name('roshta.pause');
    Route::post('/roshta/exempt', [RohtaController::class, 'exempt'])->name('roshta.exempt');


    Route::get('/show-prescription-archive', [ShowRoshtaController::class, 'showPrescriptionArchive'])->name('show-prescription-archive');
    Route::post('/roshitas/{id}/update-status', [ShowRoshtaController::class, 'updateStatus'])->name('roshitas.updateStatus');


    Route::get('/get-medicine/{code}', [MedicineController::class, 'getMedicine']);

    Route::get('/adding-medicine', [MedicineStoreController::class, 'create'])->name('add-medicine');
    Route::post('/adding-medicine', [MedicineStoreController::class, 'store'])->name('add-medicine-pharmacy');

//    Route::get('/show-orders', [MedicineController::class, 'showOrders'])->name('show-orders');
    Route::get('/pharmacy/orders', [PharmacyOrderController::class, 'index'])->name('show-orders');
    Route::post('/pharmacy/orders/{id}/accept', [PharmacyOrderController::class, 'accept'])->name('pharmacy.orders.accept');
    Route::post('/pharmacy/orders/{id}/cancel', [PharmacyOrderController::class, 'cancel'])->name('pharmacy.orders.cancel');

    Route::get('/show-pharmacy-order-archive', [MedicineController::class, 'showPharmacyOrderArchive'])->name('show-pharmacy-order-archive');
    Route::get('/orders/archive', [MedicineController::class, 'archive'])->name('orders.archive');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/daily', [ReportController::class, 'daily'])->name('reports.daily');
    Route::get('/reports/monthly', [ReportController::class, 'monthly'])->name('reports.monthly');

});

