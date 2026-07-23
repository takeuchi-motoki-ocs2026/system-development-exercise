<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Table;
use App\Models\ProductOption;
use App\Models\Call;

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
            'project.staff.order.orderHome',
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

        return redirect('/project/staff/order/home');
    
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
                'taste' => $request->taste ?? '',
            ];
        }

        session()->put('cart', $cart);

        return redirect('/project/staff/order/home')
            ->with('success', 'カートに追加しました');

    }

    public function detail($id)
    {
        $product = Product::findOrFail($id);

        
        if ($product->stock_status === '無') {

            return redirect('/project/staff/order/home');

        }

        return view('project.staff.order.detail', compact('product'));
    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('project.staff.order.cart', compact('cart'));
    }

    public function delete($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        session()->put('cart', $cart);

        return redirect('/project/staff/order/cart');
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
        }

        session()->put('cart', $cart);

        return redirect('/project/staff/order/cart');
    }

    public function confirm()
    {
        $cart = session()->get('cart', []);

        foreach ($cart as $item) {
            Order::create([
                'name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'taste' => $item['taste'] ?? '',
                'seat' => session('seat') ?? 1,
            ]);
        }

        // カート空にする
        session()->forget('cart');

        return redirect('/project/staff/order/complete');
    }

    public function history(Request $request)
    {
        $seat = $request->query('seat');

        $orders = Order::where('seat', $seat)->get();

        return view('project.staff.staff_history', compact('orders', 'seat'));
    }
    
    // --- メニュー編集一覧 ---
    // 編集画面表示
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view(
            'project.staff.menu-edit',
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
            '/project/menu-edit-list'
        );
    }
    
    // 削除処理
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return redirect(
            '/project/menu-edit-list'
        );
    }
    
    public function editList()
    {
        $products = Product::all();

        return view(
            'project.staff.menu-edit-list',
            compact('products')
        );
    }

    // 在庫管理
    public function stockStatus()
    {
        $products = Product::all();

        return view(
            'project.staff.stock-status',
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
            'project.staff.order-status',
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
            'project.customer.orderHome',
            compact('products', 'seat', 'category')
        );
    }

    public function customerDetail($id)
    {
        $product = Product::with('options')->findOrFail($id);

        if ($product->stock_status === '無') {
            return redirect('/project/orderHome');
        }

        return view('project.customer.detail', compact('product'));
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

        return view('project.customer.add');


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

        return back();
}

    // 客カート削除
    public function customerDelete($key)
    {
        $cart = session()->get('customer_cart', []);

        if(isset($cart[$key])){

            unset($cart[$key]);

        }

        session()->put('customer_cart', $cart);

        return back();
    }

    // 客カート全削除
    public function customerClear()
    {
        session()->forget('customer_cart');

        return redirect('/project/cart?cleared=1');
    }

    public function clearCart()
    {
        session()->forget('cart');

        return redirect()
            ->route('project.staff.order.cart');
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
        return redirect('/project/complete');
    }

    public function customerHistory()
    {
        $seat = session('seat') ?? 1;

        $orders = Order::where('seat', $seat)->get();

        return view(
            'project.customer.history',
            compact('orders')
        );
    }

    public function checkout()
    {
        $seat = session('seat') ?? 1;

        $orders = Order::where('seat', $seat)->get();

        return view(
            'project.customer.checkout',
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
            'project.staff.vacancy-management',
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

        $calls = Call::where('status', 'pending')->get();

        return view(
            'project.staff.seat-management',
            compact('tables', 'calls')
        );
    }

    //店員呼出
    public function callStaff()
    {
        $tableId = session('seat');

        if (!$tableId) {
            return back()->with('error', '座席情報が取得できませんでした');
        }

        Call::firstOrCreate([
            'table_id' => $tableId,
            'request_type' => 'call_staff',
            'status' => 'pending',
        ]);

        return redirect()
            ->route('projectcall')
            ->with('success', '店員を呼び出しました');
    }

    public function processingCall($tableId)
    {
        $call = Call::where('table_id', $tableId)
            ->where('status', 'pending')
            ->first();

        if ($call) {
            $call->status = 'processing';
            $call->save();
        }

        return back();
    }

    public function staffHome()
    {
        $hasPendingCall = Call::where('status', 'pending')->exists();

        return view(
            'project.staff.home',
            compact('hasPendingCall')
        );
    }

    public function pendingCallCheck()
    {
        $pendingCalls = Call::where('status', 'pending')->get();

        return response()->json([
            'hasPendingCall' => $pendingCalls->isNotEmpty(),
            'tables' => $pendingCalls->pluck('table_id')
        ]);
    }

    public function completeCheckout()
    {
        $seat = session('seat');

        if (!$seat) {
            return back()->with('error', '座席情報が取得できませんでした');
        }

        Order::where('seat', $seat)->delete();

        return redirect('/project/thanks');
    }
}
