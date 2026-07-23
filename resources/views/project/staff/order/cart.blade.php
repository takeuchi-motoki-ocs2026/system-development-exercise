<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">

  <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

  <title>注文カゴ</title>

  <link rel="stylesheet"
    href="{{ asset('css/staff_style.css') }}">
</head>
<body>

<div class="container history-page">

  <!-- ヘッダー -->
  <header>

  </header>

  <!-- タイトル -->
  <h1 class="history-title">
    注文カゴ
  </h1>

  <!-- 注文一覧 -->
  <div class="history-list">

    @foreach ($cart as $id => $item)

    <div class="history-row">
      
      <form action="/cart/delete/{{ $id }}" method="POST">
        @csrf
        <button type="submit" class="delete-item-btn">🗑</button>
      </form>

      <div class="history-item">

        <div class="history-info">

          <p class="item-name">
            {{ $item['name'] }}

            @if(!empty($item['taste']))
                （{{ $item['taste'] }}）
            @endif
          </p>

          <p class="item-price">
            {{ $item['price'] }}円
          </p>

        </div>

        <div class="item-count-control">
          <!-- − -->
          <form action="/cart/update/{{ $id }}" method="POST">
            @csrf
            <input type="hidden" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}">
            <button type="submit" class="qty-btn" {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>−</button>
          </form>

          <!-- 数量 -->
          <div class="item-count">{{ $item['quantity'] }}</div>

          <!-- ＋ -->
          <form action="/cart/update/{{ $id }}" method="POST">
            @csrf
            <input type="hidden" name="quantity" value="{{ min(5, $item['quantity'] + 1) }}">
            <button type="submit" class="qty-btn" {{ $item['quantity'] >= 4 ? 'disabled' : '' }}>＋</button>
          </form>

        </div>

      </div>

    </div>

    @endforeach

  </div>

  <!-- 合計 -->
  @php
  $total = 0;
  foreach ($cart as $item) {
      $total += $item['price'] * $item['quantity'];
  }
  @endphp

  <div class="total-area">
    合計　{{ $total }}円
  </div>

  <!-- ボタン -->
  <div class="cart-buttons">

    <form action="{{ route('project.staff.order.cart.clear') }}" method="POST">
      @csrf
      <button type="submit" class="delete-all-btn" {{ empty($cart) ? 'disabled' : '' }}>
        全て削除
      </button>
    </form>
    
    <form action="{{ route('project.staff.order.confirm') }}" method="POST">
      @csrf
      <button type="submit" class="confirm-btn" {{ empty($cart) ? 'disabled' : '' }}>
        注文確定
      </button>
    </form>

  </div>

  <!-- フッター -->
  <footer>
    <a href="{{ url('/project/staff/order/home') }}">
      <button>
        注文
      </button>
    </a>
    <a href="{{ url('project/home') }}">
      <button>
        ホーム
      </button>
    </a>
  </footer>

</div>

</body>
</html>