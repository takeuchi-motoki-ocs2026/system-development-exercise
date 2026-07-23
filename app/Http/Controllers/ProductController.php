<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
        $category = $request->get('category', 'food');

        $seat = $request->seat ?? session('seat');

        if ($seat !== null) {
            session(['seat' => $seat]);
        }

        $course = 'normal';

        if ($seat !== null) {
            $visit = DB::table('used_table')
                ->join(
                    'table',
                    'used_table.table_id',
                    '=',
                    'table.table_id'
                )
                ->where('table.table_number', $seat)
                ->whereNull('used_table.end_time')
                ->orderByDesc('used_table.start_time')
                ->select('used_table.course')
                ->first();

            if ($visit) {
                $course = $visit->course;
            }
        }

        $products = Product::where('category', $category)->get();

        return view('project.staff.order.orderHome', compact(
            'products',
            'category',
            'course'
        ));
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

        $key = $id . '_' . ($request->option ?? '');

        $seat = session('seat');

        $visit = DB::table('used_table')
            ->join(
                'table',
                'used_table.table_id',
                '=',
                'table.table_id'
            )
            ->where('table.table_number', $seat)
            ->whereNull('used_table.end_time')
            ->select('used_table.course')
            ->first();
        
        $price = $product->price;

        if (
            $visit &&
            $visit->course === 'all_you_can_drink' &&
            $product->category === 'drink'
        ) {
            $price = 0;
        }

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += (int) $request->quantity;
        } else {
            $cart[$key] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $price,
                'quantity' => (int) $request->quantity,
                'taste' => $request->option ?? '',
            ];
        }

        session()->put('cart', $cart);

        return redirect('/project/staff/order/home')
            ->with('success', 'カートに追加しました');
    }

    public function detail(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $seat = $request->query('seat', session('seat'));

        if ($seat) {
            session(['seat' => $seat]);
        }

        $course = 'normal';

        if ($seat) {

            $visit = DB::table('used_table')
                ->join('table', 'used_table.table_id', '=', 'table.table_id')
                ->where('table.table_number', $seat)
                ->whereNull('used_table.end_time')
                ->latest('used_table.start_time')
                ->select('used_table.course')
                ->first();

            if ($visit) {
                $course = $visit->course;
            }
        }

        return view(
            'project.staff.order.detail',
            compact('product', 'course')
        );
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
                'customer_id' => session('customer_id'),
                'table_id' => session('table_id'),

                'name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'taste' => $item['option'] ?? '',
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
        } else {
            $seat = session('seat');
        }

        $course = session('course') ?? 'normal';

        return view(
            'project.customer.orderHome',
            compact(
                'products',
                'seat',
                'category',
                'course'
            )
        );
    }

    public function customerDetail(Request $request, $id)
    {
        $product = Product::with('options')->findOrFail($id);

        if ($product->stock_status === '無') {
            return redirect('/project/orderHome');
        }

        $course = session('course') ?? 'normal';

        return view(
            'project.customer.detail',
            compact(
                'product',
                'course'
            )
        );
    }

    public function customerAdd(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('customer_cart', []);

        $key = $id . '_' . ($request->option ?? '');

        $price = $product->price;

        if (
            session('course') === 'all_you_can_drink' &&
            $product->category === 'drink'
        ) {
            $price = 0;
        }

        if (isset($cart[$key])) {

            $cart[$key]['quantity'] += (int)$request->quantity;

        } else {

            $cart[$key] = [
                'name' => $product->name,
                'price' => $price,
                'quantity' => (int)$request->quantity,
                'option' => $request->option ?? '',
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
                'customer_id' => session('customer_id'),
                'table_id' => session('table_id'),

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

    public function startVisit(Request $request)
    {
        $validated = $request->validate([
            'table_id' => [
                'required',
                'integer',
                'exists:table,table_id',
            ],

            'course' => [
                'required',
                'in:normal,all_you_can_drink',
            ],

            'people_count' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        $tableData = Table::findOrFail($validated['table_id']);

        // 最大人数を超えていないか確認
        if ($validated['people_count'] > $tableData->max_people) {
            return response()->json([
                'message' =>
                    "この席は最大{$tableData->max_people}人です。",
            ], 422);
        }

        // すでに使用中ではないか確認
        if ($tableData->seat_status !== 'available') {
            return response()->json([
                'message' => 'この席はすでに使用中です。',
            ], 422);
        }

        try {
            $result = DB::transaction(function () use (
                $validated,
                $tableData
            ) {
                // QR識別用の値
                $qrToken = (string) Str::uuid();

                // customerへ来店情報を登録
                $customerId = DB::table('customer')
                    ->insertGetId([
                        'payment_time' => null,
                        'billStatus' => 'unpaid',
                        'qr_code' => $qrToken,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                // used_tableへ今回の利用情報を登録
                DB::table('used_table')->insert([
                    'table_id' => $validated['table_id'],
                    'customer_id' => $customerId,
                    'people_count' => $validated['people_count'],
                    'course' => $validated['course'],
                    'start_time' => now(),
                    'end_time' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // 席を使用中にする
                $tableData->seat_status = 'occupied';
                $tableData->save();

                return [
                    'qr_token' => $qrToken,
                ];
            });

            return response()->json([
                'success' => true,

                'redirect_url' =>
                    url('/project/staff/qr')
                    . '?token='
                    . urlencode($result['qr_token']),
            ]);

        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'message' => '入店登録に失敗しました。',
            ], 500);
        }
    }

    public function enterByQr(Request $request)
    {
        $token = $request->query('token');

        if (!$token) {
            return redirect('/project')
                ->with('error', 'QRコードが正しくありません。');
        }

        $customer = DB::table('customer')
            ->where('qr_code', $token)
            ->first();

        if (!$customer) {
            return redirect('/project')
                ->with('error', '無効なQRコードです。');
        }

        if ($customer->billStatus === 'paid') {
            return redirect('/project')
                ->with('error', 'このQRコードは利用終了しています。');
        }

        $usedTable = DB::table('used_table')
            ->join(
                'table',
                'used_table.table_id',
                '=',
                'table.table_id'
            )
            ->where('used_table.customer_id', $customer->customer_id)
            ->whereNull('used_table.end_time')
            ->select(
                'used_table.*',
                'table.table_number'
            )
            ->first();

        if (!$usedTable) {
            return redirect('/project')
                ->with('error', '利用中の席情報がありません。');
        }

        session([
            'customer_id' => $customer->customer_id,
            'table_id' => $usedTable->table_id,
            'seat' => $usedTable->table_number,
            'course' => $usedTable->course,
            'people_count' => $usedTable->people_count,
            'qr_token' => $token,
        ]);
        return redirect('/project/orderHome');
    }

    public function showQr(Request $request)
    {
        $token = $request->query('token');

        if (!$token) {
            return redirect()
                ->route('project.staff.vacancy')
                ->with('error', 'QRコード情報がありません。');
        }

        $visit = DB::table('customer')
            ->join(
                'used_table',
                'customer.customer_id',
                '=',
                'used_table.customer_id'
            )
            ->join(
                'table',
                'used_table.table_id',
                '=',
                'table.table_id'
            )
            ->where('customer.qr_code', $token)
            ->whereNull('used_table.end_time')
            ->select(
                'customer.qr_code',
                'table.table_number',
                'used_table.course',
                'used_table.people_count'
            )
            ->first();

        if (!$visit) {
            return redirect()
                ->route('project.staff.vacancy')
                ->with('error', '利用情報が見つかりません。');
        }

        return view('project.staff.qr', [
            'token' => $visit->qr_code,
            'seat' => $visit->table_number,
            'course' => $visit->course,
            'people' => $visit->people_count,
        ]);
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

    public function staffOrderHome(Request $request)
    {
        $category = $request->get('category', 'food');

        $seat = $request->seat ?? session('seat');

        if ($seat !== null) {
            session(['seat' => $seat]);
        }

        $visit = DB::table('used_table')
            ->join(
                'table',
                'used_table.table_id',
                '=',
                'table.table_id'
            )
            ->where('table.table_number', $seat)
            ->whereNull('used_table.end_time')
            ->orderByDesc('used_table.start_time')
            ->select('used_table.course')
            ->first();

        $course = $visit?->course ?? 'normal';

        $products = Product::where('category', $category)->get();

        return view(
            'project.staff.order.home',
            compact('products', 'category', 'course')
        );
    }

}
