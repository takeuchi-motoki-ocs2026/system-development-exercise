@php
    $cart = session('customer_cart', []);
    $cartEmpty = request('cleared') == 1 || count($cart) === 0;
@endphp

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">

  <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

  <title>注文カゴ</title>

  <link rel="stylesheet"
    href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container cart-page">

  <!-- ヘッダー -->
  <header>

    <div class="time">
      残り時間 60分
    </div>

  </header>

  <!-- タイトル -->
  <h1 class="history-title">
    注文カゴ
  </h1>

  <!-- 注文一覧 -->
  <div class="history-list">

    @if($cartEmpty)
      <div class="empty-cart-message">
        カゴの中身はありません
      </div>
    @else
      @if(count(session('customer_cart', [])) > 0)

      @foreach(session('customer_cart') as $key => $item)
        <div class="history-row">


          <form action="{{ url('/prototype/cart/delete/'.$key) }}" method="POST">
            @csrf

            <button type="submit" class="delete-item-btn">
              🗑
            </button>

          </form>

          <div class="history-item">

            <div class="history-info">

              <p class="item-name">

                {{ $item['name'] }}

                @if(!empty($item['option']))
                  （{{ $item['option'] }}）
                @endif

              </p>

              <p class="item-price">
                {{ $item['price'] }}円
              </p>

            </div>

            <div class="item-count-control">

              <form action="{{ url('/prototype/cart/update/'.$key) }}" method="POST">
              @csrf

                <button
                type="submit"
                name="quantity"
                value="{{ max(1, $item['quantity'] - 1) }}"
                class="qty-btn minus-btn">
                  −
                </button>

                <div class="item-count">
                  {{ $item['quantity'] }}
                </div>

                <button
                type="submit"
                name="quantity"
                value="{{ $item['quantity'] + 1 }}"
                class="qty-btn plus-btn">
                  +
                </button>

              </form>

            </div>

          </div>

        </div>
        @endforeach

      @else

      <div class="empty-cart-message">
        カゴの中身はありません
      </div>

      @endif
    @endif

  </div>

  <!-- 合計 -->
  @php
    $total = 0;

    foreach(session('customer_cart', []) as $item){
        $total += $item['price'] * $item['quantity'];
    }
  @endphp

  <div class="total-area">
    合計　{{ $total }}円
  </div>

  <!-- ボタン -->
  <div class="cart-buttons">

    @if($cartEmpty)
      <button class="delete-all-btn" disabled>
        全て削除
      </button>

      <button class="confirm-btn" disabled>
        注文確定
      </button>
    @else
      <form action="{{ url('/prototype/cart/clear') }}" method="POST">
      @csrf

      <button class="delete-all-btn">
      全て削除
      </button>

      </form>

      <a href="{{ url('/prototype/confirm') }}">
        <button class="confirm-btn">
          注文確定
        </button>
      </a>
    @endif

  </div>

  <!-- フッター -->
  <footer>

    <a href="{{ url('/prototype/orderHome') }}">
      <button>
        注文<br>追加
      </button>
    </a>

    <button type="button">注文<br>カゴ</button>

    <a href="{{ url('/prototype/history') }}">
      <button>
        注文<br>履歴
      </button>
    </a>

    <a href="{{ url('/prototype/call') }}">
      <button>
        店員<br>呼出
      </button>
    </a>

    <a href="{{ url('/prototype/checkout') }}">
      <button>
        会計
      </button>
    </a>

  </footer>

</div>

<script src="{{ asset('js/cart.js') }}" defer></script>

@include('prototype.partials.call-confirm')

<script src="{{ asset('js/call-confirm.js') }}"></script>
</body>
</html>