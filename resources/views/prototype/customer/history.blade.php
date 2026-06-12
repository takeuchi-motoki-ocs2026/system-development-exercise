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
  <div class="history-list">

    <!-- 商品 -->
    <div class="history-item">

      <div class="history-info">

        <p class="item-name">
          ねぎま（塩）
        </p>

        <p class="item-price">
          １５０円
        </p>

      </div>

      <div class="item-count">
        1
      </div>

    </div>

    <!-- 商品 -->
    <div class="history-item">

      <div class="history-info">

        <p class="item-name">
          生ビール
        </p>

        <p class="item-price">
          ５５０円
        </p>

      </div>

      <div class="item-count">
        2
      </div>

    </div>

  </div>

  <div class="total-area">
    合計　1,250円
  </div>

  <!-- フッター -->
  <footer>

    <a href="{{ url('/prototype/orderHome') }}">
      <button>
        注文
      </button>
    </a>

    <a href="{{ url('/prototype/cart') }}">
      <button>
        注文カゴ
      </button>
    </a>

    <a href="{{ url('/prototype/call') }}">
      <button>
        店員呼出
      </button>

    </a>

    <a href="{{ url('/prototype/checkout') }}">
      <button>会計　　</button>
    </a>

  </footer>

</div>

</body>
</html>