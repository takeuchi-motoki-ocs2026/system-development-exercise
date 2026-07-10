@php
  $cartEmpty = request('cleared') == 1;
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

    <!-- 商品 -->
    <div class="history-row">

      <button class="delete-item-btn">
        🗑
      </button>

      <div class="history-item">

        <div class="history-info">

          <p class="item-name">
            ねぎま（塩）
          </p>

          <p class="item-price">
            150円
          </p>

        </div>

        <div class="item-count-control">
          <button class="qty-btn minus-btn">−</button>
          <div class="item-count">1</div>
          <button class="qty-btn plus-btn">+</button>
        </div>

      </div>

    </div>

    <!-- 商品 -->
    <div class="history-row">

      <button class="delete-item-btn">
        🗑
      </button>

      <div class="history-item">

        <div class="history-info">

          <p class="item-name">
            生ビール
          </p>

          <p class="item-price">
            0円
          </p>

        </div>

        <div class="item-count-control">
          <button class="qty-btn minus-btn">−</button>
          <div class="item-count">2</div>
          <button class="qty-btn plus-btn">+</button>
        </div>

      </div>

    </div>

    @endif

  </div>

  <!-- 合計 -->
  <div class="total-area">
    合計　150円
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
      <a href="{{ url('/prototype/delete') }}">
        <button class="delete-all-btn">
          全て削除
        </button>
      </a>

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