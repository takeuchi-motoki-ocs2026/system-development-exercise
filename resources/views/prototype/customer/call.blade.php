<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>店員呼出</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container">

  <header>
    <div class="time">残り時間 60分</div>
  </header>

  <div class="call-area">

    <div class="call-message">
      <strong>ただいま、<br>
      店員呼出中です</strong>
    </div>

    <a href="{{ url('/prototype/orderHome') }}">
      <button class="call-back-btn">戻る</button>
    </a>

  </div>

  <footer>

    <a href="{{ url('/prototype/orderHome') }}"><button>注文</button></a>

    <a href="{{ url('/prototype/cart') }}"><button>注文<br>カゴ</button></a>

    <a href="{{ url('/prototype/history') }}"><button>注文<br>履歴</button></a>

    <button type="button">店員<br>呼出</button>

    <a href="{{ url('/prototype/checkout') }}"><button>会計</button></a>

  </footer>

</div>

@include('prototype.partials.call-confirm')

<script src="{{ asset('js/call-confirm.js') }}"></script>

</body>
</html>