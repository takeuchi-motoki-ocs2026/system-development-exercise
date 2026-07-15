<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Table;

class ProductController extends Controller
{
    // 一覧表示（orderHome用）
    public function index(Request $request)
    {
        $category = $request->query('category', 'food');

        $products = Product::where(
            'category',
            $category
        )->get();

        $seat = $request->query('seat');

        if ($seat !== null) {
            session(['seat' => $seat]);
        }

        return view(
            'prototype.staff.order.orderHome',
            compact('products', 'seat', 'category')
        );
    }

    // 登録処理（menu-add用）
    public function store(Request $request)
    {
        $imagePath = null;

        if ($request->hasFile('image')) {

            $imagePath = $request
                ->file('image')
                ->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $imagePath,
            'category' => $request->category,
            'shop_id' => 1
        ]);

        return redirect('/prototype/staff/order/home');
    
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $request->quantity;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
                'taste' => $request->taste
            ];
        }

        session()->put('cart', $cart);

        return redirect('/prototype/staff/order/home')
            ->with('success', 'カートに追加しました');

    }

    public function detail($id)
    {
        $product = Product::findOrFail($id);

        
        if ($product->stock_status === '無') {

            return redirect('/prototype/staff/order/home');

        }

        return view('prototype.staff.order.detail', compact('product'));
    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('prototype.staff.order.cart', compact('cart'));
    }

    public function delete($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        session()->put('cart', $cart);

        return redirect('/prototype/staff/order/cart');
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
        }

        session()->put('cart', $cart);

        return redirect('/prototype/staff/order/cart');
    }

    public function confirm()
    {
        $cart = session()->get('cart', []);

        foreach ($cart as $item) {
            Order::create([
                'name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'taste' => $item['taste'],
                'seat' => session('seat') ?? 1,
            ]);
        }

        // カート空にする
        session()->forget('cart');

        return redirect('/prototype/staff/order/complete');
    }

    public function history(Request $request)
    {
        $seat = $request->query('seat');

        $orders = Order::where('seat', $seat)->get();

        return view('prototype.staff.staff_history', compact('orders', 'seat'));
    }
    
    // --- メニュー編集一覧 ---
    // 編集画面表示
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view(
            'prototype.staff.menu-edit',
            compact('product')
        );
    }

    // 更新処理
    public function updateProduct(
        Request $request,
        $id
    ){
        $product = Product::findOrFail($id);

        $imagePath = $product->image;

        if ($request->hasFile('image')) {

            $imagePath = $request
                ->file('image')
                ->store('products', 'public');
        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

        return redirect(
            '/prototype/menu-edit-list'
        );
    }
    
    // 削除処理
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return redirect(
            '/prototype/menu-edit-list'
        );
    }
    
    public function editList()
    {
        $products = Product::all();

        return view(
            'prototype.staff.menu-edit-list',
            compact('products')
        );
    }

    // 在庫管理
    public function stockStatus()
    {
        $products = Product::all();

        return view(
            'prototype.staff.stock-status',
            compact('products')
        );
    }

    // 在庫状態更新
    public function updateStock(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->stock_status = $request->stock_status;

        $product->save();

        return back();
    }

    // 注文データ取得
    public function orderStatus()
    {

        $orders = Order::whereColumn(
            'served_quantity',
            '<',
            'quantity'
        )->get();

        return view(
            'prototype.staff.order-status',
            compact('orders')
        );
    }
    
    public function updateServed(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $order->served_quantity =
            $request->served_quantity;

        $order->save();

        return response()->json([
            'success' => true
        ]);
    }

    ///客用
    public function customerIndex(Request $request)
    {
        $products = Product::all();
        $seat = $request->query('seat');

        if ($seat !== null) {
            session(['seat' => $seat]);
        }

        return view('prototype.customer.orderHome', compact('products', 'seat'));
    }

    public function customerDetail($id)
    {
        $product = Product::findOrFail($id);

        if ($product->stock_status === '無') {
            return redirect('/prototype/orderHome');
        }

        return view('prototype.customer.detail', compact('product'));
    }

    // 空席管理
    public function vacancyManagement()
    {
        $tables = Table::where(
            'seat_status',
            'available'
        )->get();

        return view(
            'prototype.staff.vacancy-management',
            compact('tables')
        );
    }

    // 席状態（空→使）
    public function useSeat($id)
    {
        $table = Table::findOrFail($id);

        $table->seat_status = 'occupied';

        $table->save();

        return response()->json();
    }

    public function occupySeat($id)
    {
        $table = Table::findOrFail($id);

        $table->seat_status = 'occupied';

        $table->save();

        return response()->json([
            'success' => true
        ]);
    }

    // 席状態（使→空）
    public function emptySeat($id)
    {
        $table = Table::findOrFail($id);

        $table->seat_status = 'available';

        $table->save();

        return response()->json();
    }

    public function seatManagement()
    {
        $tables = Table::all();

        return view(
            'prototype.staff.seat-management',
            compact('tables')
        );
    }
}
