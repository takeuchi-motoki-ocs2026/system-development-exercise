<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'customerIndex']);

Route::view('/project', 'project.customer.index')->name('project');


Route::view('/project/home', 'project.customer.home')->name('projecthome');

Route::get('/project/orderHome', [ProductController::class, 'customerIndex'])
    ->name('projectorderHome');

Route::get('/project/detail/{id}', [ProductController::class, 'customerDetail'])
    ->name('projectdetail');
    
Route::view('/project/cart', 'project.customer.cart')->name('projectcart');

Route::view('/project/delete', 'project.customer.delete')->name('projectdelete');

Route::get('/project/history', [ProductController::class, 'customerHistory'])
    ->name('projecthistory');

Route::view('/project/call', 'project.customer.call')->name('projectcall');

Route::post(
    '/call/{table}/processing',
    [ProductController::class, 'processingCall']
)->name('call.processing');

Route::post(
    '/project/call',
    [ProductController::class, 'callStaff']
)->name('project.call.store');

Route::get(
    '/project/checkout',
    [ProductController::class, 'checkout']
)->name('projectcheckout');

Route::get('/project/confirm', function () {
    return view('project.customer.confirm');
})->name('projectconfirm');

Route::post(
    '/project/checkout/complete',
    [ProductController::class, 'completeCheckout']
)->name('project.checkout.complete');

Route::post('/project/confirm', [ProductController::class, 'customerConfirm'])
    ->name('project.customer.confirm');

Route::view('/project/add', 'project.customer.add')->name('projectadd');

Route::view('/project/complete', 'project.customer.complete')->name('projectcomplete');

Route::view('/project/thanks', 'project.customer.thanks')->name('projectthanks');

Route::view('/project/login', 'project.staff.login')->name('projectlogin');

Route::get(
    '/project/home',
    [ProductController::class, 'staffHome']
)->name('projecthome');

Route::view('/project/order-menu', 'project.staff.order-menu')->name('projectorder-menu');

Route::view('/project/order-history', 'project.staff.order-history')->name('projectorder-history');

Route::view('/project/menu-management', 'project.staff.menu-management')->name('projectmenu-management');

Route::view('/project/menu-add', 'project.staff.menu-add')->name('projectmenu-add');

Route::view('/project/menu-edit', 'project.staff.menu-edit')->name('projectmenu-edit');

Route::redirect('/project/staff/order', '/project/staff/order/home');

Route::view('/project/staff/order/add', 'project.staff.order.add')->name('project.staff.order.add');

Route::view('/project/staff/order/delete', 'project.staff.order.delete')->name('project.staff.order.delete');

Route::view('/project/staff/order/complete', 'project.staff.order.complete')->name('project.staff.order.complete');

Route::view('/project/staff/order/history', 'project.staff.order.history')->name('project.staff.order.history');

Route::view('/project/staff/order', 'project.staff.order')->name('project.staff.order');

Route::get(
    '/project/staff/qr',
    [ProductController::class, 'showQr']
)->name('project.staff.qr');

Route::get(
    '/project/entry',
    [ProductController::class, 'enterByQr']
)->name('project.entry');

Route::get(
    '/project/call/pending-check',
    [ProductController::class, 'pendingCallCheck']
)->name('project.call.pending-check');




// 一覧表示
Route::get('/project/staff/order/home', [ProductController::class, 'index'])
    ->name('project.staff.order.home');

// 追加処理
Route::post('/menu/add', [ProductController::class, 'store']);

// カート表示
Route::get('/project/staff/order/cart', [ProductController::class, 'cart'])
    ->name('project.staff.order.cart');

// 注文カゴ追加
Route::post('/cart/add/{id}', [ProductController::class, 'add']);
Route::post('/project/cart/add/{id}', [ProductController::class, 'customerAdd']);

// 客カート数量変更
Route::post('/project/cart/update/{key}', [ProductController::class, 'customerUpdate']);

// 客カート商品削除
Route::post('/project/cart/delete/{key}', [ProductController::class, 'customerDelete']);

// 客カート全削除
Route::post('/project/cart/clear', [ProductController::class, 'customerClear']);

Route::post(
    '/project/staff/order/cart/clear',
    [ProductController::class, 'clearCart']
)->name('project.staff.order.cart.clear');

Route::get('/project/staff/order/detail/{id}', [ProductController::class, 'detail']);

Route::post('/cart/delete/{id}', [ProductController::class, 'delete']);

Route::post('/cart/update/{id}', [ProductController::class, 'update']);

Route::post('/project/staff/order/confirm', [ProductController::class, 'confirm'])
    ->name('project.staff.order.confirm');

// --- メニュー編集一覧 ---
// 編集画面
Route::get('/project/staff/staff-history', [ProductController::class, 'history'])
    ->name('project.staff.staff.history');

// 更新処理
Route::get('/menu/edit/{id}', [ProductController::class, 'edit']);

Route::post('/menu/edit/{id}',[ProductController::class, 'updateProduct'])
    ->name('projectmenu-update');

// 削除処理
Route::delete('/menu/delete/{id}', [ProductController::class, 'destroy']);

Route::get('/project/menu-edit-list', [ProductController::class, 'editList'])
    ->name('projectmenu-edit-list');

Route::post('/menu/update/{id}', [ProductController::class, 'updateProduct']);

// 在庫管理
Route::get('/project/stock-status',[ProductController::class, 'stockStatus'])
    ->name('projectstock-status');

// 在庫更新
Route::post('/project/stock-status/update/{id}',[ProductController::class, 'updateStock']);

// 注文データ取得
Route::get('/project/order-status',[ProductController::class, 'orderStatus'])
    ->name('projectorder-status');

Route::post('/order-status/update/{id}',[ProductController::class, 'updateServed']);

// 注文状況
Route::post('/order-status/update/{id}',[ProductController::class, 'updateServed']);

// 空席管理
Route::get(
    '/project/staff/vacancy',
    [ProductController::class, 'vacancyManagement']
)->name('project.staff.vacancy');

// QR発行前の入店登録
Route::post(
    '/project/staff/visit',
    [ProductController::class, 'startVisit']
)->name('project.staff.visit.store');

// 席状態（空→使）
Route::post('/seat/use/{id}',[ProductController::class, 'useSeat']);

Route::post('/seat/occupy/{id}',[ProductController::class, 'occupySeat']);

// 席状態（使→空）
Route::post('/seat/empty/{id}',[ProductController::class, 'emptySeat']);

// 座席管理
Route::get('/project/seat-management',[ProductController::class, 'seatManagement'])
    ->name('projectseat-management');