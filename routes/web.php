<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('prototype.customer.orderHome');
});

Route::view('/prototype', 'prototype.customer.index')->name('prototype');


Route::view('/prototype/home', 'prototype.customer.home')->name('prototypehome');

Route::view('/prototype/orderHome', 'prototype.customer.orderHome')->name('prototypeorderHome');

Route::view('/prototype/detail', 'prototype.customer.detail')->name('prototypedetail');

Route::view('/prototype/cart', 'prototype.customer.cart')->name('prototypecart');

Route::view('/prototype/delete', 'prototype.customer.delete')->name('prototypedelete');

Route::view('/prototype/history', 'prototype.customer.history')->name('prototypehistory');

Route::view('/prototype/call', 'prototype.customer.call')->name('prototypecall');

Route::view('/prototype/checkout', 'prototype.customer.checkout')->name('prototypecheckout');

Route::view('/prototype/confirm', 'prototype.customer.confirm')->name('prototypeconfirm');

Route::view('/prototype/add', 'prototype.customer.add')->name('prototypeadd');

Route::view('/prototype/complete', 'prototype.customer.complete')->name('prototypecomplete');

Route::view('/prototype/thanks', 'prototype.customer.thanks')->name('prototypethanks');

Route::view('/prototype/login', 'prototype.staff.login')->name('prototypelogin');

Route::view('/prototype/home', 'prototype.staff.home')->name('prototypehome');

Route::view('/prototype/order-menu', 'prototype.staff.order-menu')->name('prototypeorder-menu');

Route::view('/prototype/order-history', 'prototype.staff.order-history')->name('prototypeorder-history');

Route::view('/prototype/order-status', 'prototype.staff.order-status')->name('prototypeorder-status');

Route::view('/prototype/seat-management', 'prototype.staff.seat-management')->name('prototypeseat-management');

Route::view('/prototype/menu-management', 'prototype.staff.menu-management')->name('prototypemenu-management');

Route::view('/prototype/stock-status', 'prototype.staff.stock-status')->name('prototypestock-status');

Route::view('/prototype/menu-add', 'prototype.staff.menu-add')->name('prototypemenu-add');

Route::view('/prototype/menu-edit', 'prototype.staff.menu-edit')->name('prototypemenu-edit');

Route::redirect('/prototype/staff/order', '/prototype/staff/order/home');

Route::view('/prototype/staff/order/add', 'prototype.staff.order.add')->name('prototype.staff.order.add');

Route::view('/prototype/staff/order/delete', 'prototype.staff.order.delete')->name('prototype.staff.order.delete');

Route::view('/prototype/staff/order/complete', 'prototype.staff.order.complete')->name('prototype.staff.order.complete');

Route::view('/prototype/staff/order/history', 'prototype.staff.order.history')->name('prototype.staff.order.history');

Route::view('/prototype/staff/order', 'prototype.staff.order')->name('prototype.staff.order');

Route::view('/prototype/staff/vacancy', 'prototype.staff.vacancy-management')->name('prototype.staff.vacancy');

Route::get('/prototype/staff/qr', function (Request $request) {
    return view('prototype.staff.qr', [
        'seat' => $request->query('seat'),
        'course' => $request->query('course'),
    ]);
})->name('prototype.staff.qr');

Route::post('/prototype/cart/clear', function (Request $request) {
    $request->session()->forget('cart');
    return redirect('/prototype/cart?cleared=1');
})->name('prototype.cart.clear');

Route::post('/prototype/staff/order/cart/clear', function (Request $request) {
    $request->session()->forget('cart');
    return redirect()->route('prototype.staff.order.cart', ['cleared' => 1]);
})->name('prototype.staff.order.cart.clear');












use App\Http\Controllers\ProductController;

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

// 削除処理
Route::delete('/menu/delete/{id}', [ProductController::class, 'destroy']);

Route::get('/prototype/menu-edit-list', [ProductController::class, 'editList'])
    ->name('prototypemenu-edit-list');

Route::post('/menu/update/{id}', [ProductController::class, 'updateProduct']);
