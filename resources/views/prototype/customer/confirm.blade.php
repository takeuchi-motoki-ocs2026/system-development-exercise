<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>注文確認</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container">

  <header>
    <div class="time">残り時間 60分</div>
  </header>

  <nav class="tabs">
    <button class="tab">料理</button>
    <button class="tab">ドリンク</button>
    <button class="tab">サービス</button>
    <button class="tab">店舗限定</button>
  </nav>

  <div class="confirm-area">

    <h1>注文を確定しますか？</h1>

    <div class="confirm-buttons">

      <a href="{{ url('/prototype/cart') }}">
        <button>いいえ</button>
      </a>

      <a href="{{ url('/prototype/complete') }}">
        <button>はい</button>
      </a>

    </div>

  </div>

  <footer>

    <a href="{{ url('/prototype/orderHome') }}">
      <button>注文<br>追加</button>
    </a>

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

</body>
</html>