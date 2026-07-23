<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">

  <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

  <title>注文履歴</title>

  <link rel="stylesheet"
    href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container history-page">

  <!-- ヘッダー -->
  <header>

    <div class="time">
      残り時間 60分
    </div>

  </header>

  <!-- タイトル -->
  <h1 class="history-title">
    注文履歴
  </h1>

  <!-- 注文一覧 -->
  @if(count($orders) > 0)

  @foreach($orders as $order)

  <div class="history-item">

    <div class="history-info">

      <p class="item-name">

        {{ $order->name }}

        @if(!empty($order->taste))
          （{{ $order->taste }}）
        @endif

      </p>


      <p class="item-price">
        {{ $order->price }}円
      </p>

    </div>


    <div class="item-count">
      {{ $order->quantity }}
    </div>

  </div>

  @endforeach


  @else

  <div class="empty-cart-message">
    注文履歴はありません
  </div>

  @endif

  @php
  $total = 0;

  foreach($orders as $order){
      $total += $order->price * $order->quantity;
  }
  @endphp


  <div class="total-area">
    合計　{{ $total }}円
  </div>

  <!-- フッター -->
  <footer>

    <a href="{{ url('/project/orderHome') }}">
      <button>
        注文<br>追加
      </button>
    </a>

    <a href="{{ url('/project/cart') }}">
      <button>
        注文<br>カゴ
      </button>
    </a>

    <button type="button">注文<br>履歴</button>

    <a href="{{ url('/project/call') }}">
      <button>
        店員<br>呼出
      </button>

    </a>

    <a href="{{ url('/project/checkout') }}">
      <button>会計</button>
    </a>

  </footer>

</div>

@include('project.partials.call-confirm')

<script src="{{ asset('js/call-confirm.js') }}"></script>

</body>
</html>