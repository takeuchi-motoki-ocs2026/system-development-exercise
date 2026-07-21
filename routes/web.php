<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'customerIndex']);

Route::view('/prototype', 'prototype.customer.index')->name('prototype');


Route::view('/prototype/home', 'prototype.customer.home')->name('prototypehome');

Route::get('/prototype/orderHome', [ProductController::class, 'customerIndex'])
    ->name('prototypeorderHome');

Route::get('/prototype/detail/{id}', [ProductController::class, 'customerDetail'])
    ->name('prototypedetail');
    
Route::view('/prototype/cart', 'prototype.customer.cart')->name('prototypecart');

Route::view('/prototype/delete', 'prototype.customer.delete')->name('prototypedelete');

Route::get('/prototype/history', [ProductController::class, 'customerHistory'])
    ->name('prototypehistory');

Route::view('/prototype/call', 'prototype.customer.call')->name('prototypecall');

Route::post(
    '/call/{table}/processing',
    [ProductController::class, 'processingCall']
)->name('call.processing');

Route::post(
    '/prototype/call',
    [ProductController::class, 'callStaff']
)->name('prototype.call.store');

Route::get(
    '/prototype/checkout',
    [ProductController::class, 'checkout']
)->name('prototypecheckout');

Route::get('/prototype/confirm', function () {
    return view('prototype.customer.confirm');
})->name('prototypeconfirm');

Route::post(
    '/prototype/checkout/complete',
    [ProductController::class, 'completeCheckout']
)->name('prototype.checkout.complete');

Route::post('/prototype/confirm', [ProductController::class, 'customerConfirm'])
    ->name('prototype.customer.confirm');

Route::view('/prototype/add', 'prototype.customer.add')->name('prototypeadd');

Route::view('/prototype/complete', 'prototype.customer.complete')->name('prototypecomplete');

Route::view('/prototype/thanks', 'prototype.customer.thanks')->name('prototypethanks');

Route::view('/prototype/login', 'prototype.staff.login')->name('prototypelogin');

Route::get(
    '/prototype/home',
    [ProductController::class, 'staffHome']
)->name('prototypehome');

Route::view('/prototype/order-menu', 'prototype.staff.order-menu')->name('prototypeorder-menu');

Route::view('/prototype/order-history', 'prototype.staff.order-history')->name('prototypeorder-history');

Route::view('/prototype/menu-management', 'prototype.staff.menu-management')->name('prototypemenu-management');

Route::view('/prototype/menu-add', 'prototype.staff.menu-add')->name('prototypemenu-add');

Route::view('/prototype/menu-edit', 'prototype.staff.menu-edit')->name('prototypemenu-edit');

Route::redirect('/prototype/staff/order', '/prototype/staff/order/home');

Route::view('/prototype/staff/order/add', 'prototype.staff.order.add')->name('prototype.staff.order.add');

Route::view('/prototype/staff/order/delete', 'prototype.staff.order.delete')->name('prototype.staff.order.delete');

Route::view('/prototype/staff/order/complete', 'prototype.staff.order.complete')->name('prototype.staff.order.complete');

Route::view('/prototype/staff/order/history', 'prototype.staff.order.history')->name('prototype.staff.order.history');

Route::view('/prototype/staff/order', 'prototype.staff.order')->name('prototype.staff.order');

Route::get('/prototype/staff/qr', function (Request $request) {
    return view('prototype.staff.qr', [
        'seat' => $request->query('seat'),
        'course' => $request->query('course'),
    ]);
})->name('prototype.staff.qr');

Route::get(
    '/prototype/call/pending-check',
    [ProductController::class, 'pendingCallCheck']
)->name('prototype.call.pending-check');




// 一覧表示
Route::get('/prototype/staff/order/home', [ProductController::class, 'index'])
    ->name('prototype.staff.order.home');

// 追加処理
Route::post('/menu/add', [ProductController::class, 'store']);

// カート表示
Route::get('/prototype/staff/order/cart', [ProductController::class, 'cart'])
    ->name('prototype.staff.order.cart');

// 注文カゴ追加
Route::post('/cart/add/{id}', [ProductController::class, 'add']);
Route::post('/prototype/cart/add/{id}', [ProductController::class, 'customerAdd']);

// 客カート数量変更
Route::post('/prototype/cart/update/{key}', [ProductController::class, 'customerUpdate']);

// 客カート商品削除
Route::post('/prototype/cart/delete/{key}', [ProductController::class, 'customerDelete']);

// 客カート全削除
Route::post('/prototype/cart/clear', [ProductController::class, 'customerClear']);

Route::post(
    '/prototype/staff/order/cart/clear',
    [ProductController::class, 'clearCart']
)->name('prototype.staff.order.cart.clear');

Route::get('/prototype/staff/order/detail/{id}', [ProductController::class, 'detail']);

Route::post('/cart/delete/{id}', [ProductController::class, 'delete']);

Route::post('/cart/update/{id}', [ProductController::class, 'update']);

Route::post('/prototype/staff/order/confirm', [ProductController::class, 'confirm'])
    ->name('prototype.staff.order.confirm');

// --- メニュー編集一覧 ---
// 編集画面
Route::get('/prototype/staff/staff-history', [ProductController::class, 'history'])
    ->name('prototype.staff.staff.history');

// 更新処理
Route::get('/menu/edit/{id}', [ProductController::class, 'edit']);

Route::post('/menu/edit/{id}',[ProductController::class, 'updateProduct'])
    ->name('prototypemenu-update');

// 削除処理
Route::delete('/menu/delete/{id}', [ProductController::class, 'destroy']);

Route::get('/prototype/menu-edit-list', [ProductController::class, 'editList'])
    ->name('prototypemenu-edit-list');

Route::post('/menu/update/{id}', [ProductController::class, 'updateProduct']);

// 在庫管理
Route::get('/prototype/stock-status',[ProductController::class, 'stockStatus'])
    ->name('prototypestock-status');

// 在庫更新
Route::post('/prototype/stock-status/update/{id}',[ProductController::class, 'updateStock']);

// 注文データ取得
Route::get('/prototype/order-status',[ProductController::class, 'orderStatus'])
    ->name('prototypeorder-status');

Route::post('/order-status/update/{id}',[ProductController::class, 'updateServed']);

// 注文状況
Route::post('/order-status/update/{id}',[ProductController::class, 'updateServed']);

// 空席管理
Route::get('/prototype/staff/vacancy',[ProductController::class, 'vacancyManagement'])
    ->name('prototype.staff.vacancy');

// 席状態（空→使）
Route::post('/seat/use/{id}',[ProductController::class, 'useSeat']);

Route::post('/seat/occupy/{id}',[ProductController::class, 'occupySeat']);

// 席状態（使→空）
Route::post('/seat/empty/{id}',[ProductController::class, 'emptySeat']);

// 座席管理
Route::get('/prototype/seat-management',[ProductController::class, 'seatManagement'])
    ->name('prototypeseat-management');