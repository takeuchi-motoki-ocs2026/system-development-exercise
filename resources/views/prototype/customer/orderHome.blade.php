<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>モバイルオーダー</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body data-detail-url="{{ url('/prototype/detail') }}">

<div class="container">

  <header>
    <div class="time">残り時間 60分</div>
  </header>

  <nav class="tabs">

    <button class="tab active" onclick="showMenu('food', event)">
      料理
    </button>

    <button class="tab" onclick="showMenu('drink', event)">
      ドリンク
    </button>

    <button class="tab" onclick="showMenu('service', event)">
      サービス
    </button>

    <button class="tab" onclick="showMenu('limited', event)">
      店舗限定
    </button>
    
  </nav>

  <main id="menu-list"></main>

  <footer>

    <button type="button">注文</button>

    <a href="{{ url('/prototype/cart') }}">
      <button>注文<br>カゴ</button>
    </a>

    <a href="{{ url('/prototype/history') }}">
      <button>注文<br>履歴</button>
    </a>

    <a href="{{ url('/prototype/call') }}">
      <button>店員<br>呼出</button>
    </a>

    <a href="{{ url('/prototype/checkout') }}">
      <button>会計</button>
    </a>

  </footer>

</div>

@include('prototype.partials.call-confirm')

<script src="{{ asset('js/call-confirm.js') }}"></script>
<script src="{{ asset('js/order-home.js') }}"></script>

</body>
</html>