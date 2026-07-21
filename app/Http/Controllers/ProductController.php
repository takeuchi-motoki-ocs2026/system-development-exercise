<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Table;
use App\Models\ProductOption;

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

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $imagePath,
            'category' => $request->category,
            'has_option' => $request->has_option,
            'shop_id' => 1
        ]);

        if ($request->has_option) {

            foreach ($request->options as $option) {

                if (trim($option) !== '') {

                    ProductOption::create([
                        'product_id' => $product->id,
                        'option_name' => $option
                    ]);

                }
            }
        }

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
            'prototype.customer.orderHome',
            compact('products', 'seat', 'category')
        );
    }

    public function customerDetail($id)
    {
        $product = Product::with('options')->findOrFail($id);

        if ($product->stock_status === '無') {
            return redirect('/prototype/orderHome');
        }

        return view('prototype.customer.detail', compact('product'));
    }

    public function customerAdd(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('customer_cart', []);

        $key = $id . '_' . $request->option;


        if (isset($cart[$key])) {

            $cart[$key]['quantity'] += $request->quantity;

        } else {

            $cart[$key] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
                'option' => $request->option
            ];

        }


        session()->put('customer_cart', $cart);

        return view('prototype.customer.add');


    }

    // 客カート数量変更
    public function customerUpdate(Request $request, $key)
    {
        $cart = session()->get('customer_cart', []);

        if(isset($cart[$key])){

            $quantity = $request->quantity;

            if($quantity < 1){
                $quantity = 1;
            }

            if($quantity > 4){
                $quantity = 4;
            }

            $cart[$key]['quantity'] = $quantity;

        }

        session()->put('customer_cart', $cart);

        return redirect('/prototype/add');
}

    // 客カート削除
    public function customerDelete($key)
    {
        $cart = session()->get('customer_cart', []);

        if(isset($cart[$key])){

            unset($cart[$key]);

        }

        session()->put('customer_cart', $cart);

        return redirect('/prototype/add');
    }

    // 客カート全削除
    public function customerClear()
    {
        session()->forget('customer_cart');

        return redirect('/prototype/cart?cleared=1');
    }

    public function customerConfirm()
    {
        $cart = session()->get('customer_cart', []);

        foreach ($cart as $item) {

            Order::create([
                'name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'taste' => $item['option'] ?? '',
                'seat' => session('seat') ?? 1,
            ]);

        }

        // 客カート削除
        session()->forget('customer_cart');

        // 完了画面へ
        return redirect('/prototype/complete');
    }

    public function customerHistory()
    {
        $seat = session('seat') ?? 1;

        $orders = Order::where('seat', $seat)->get();

        return view(
            'prototype.customer.history',
            compact('orders')
        );
    }

    public function checkout()
    {
        $seat = session('seat') ?? 1;

        $orders = Order::where('seat', $seat)->get();

        return view(
            'prototype.customer.checkout',
            compact('orders')
        );
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
