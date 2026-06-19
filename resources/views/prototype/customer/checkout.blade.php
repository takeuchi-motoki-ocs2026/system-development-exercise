<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>会計確認</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container">

  <header>
    <div class="time">残り時間 60分</div>
  </header>

  <div class="call-area">

    <div class="call-message checkout-message">
      会計に進みます<br>
      よろしいですか？
    </div>

    <div class="checkout-total">合計　1,250円</div>

    <div class="confirm-buttons">
      <a href="{{ url('/prototype/thanks') }}"><button>はい</button></a>
      <button onclick="history.back()">戻る</button>
    </div>

  </div>

  <footer>
    <a href="{{ url('/prototype/orderHome') }}"><button>注文</button></a>
    <a href="{{ url('/prototype/cart') }}"><button>注文<br>カゴ</button></a>
    <a href="{{ url('/prototype/history') }}"><button>注文<br>履歴</button></a>
    <a href="{{ url('/prototype/call') }}"><button>店員<br>呼出</button></a>
    <button type="button">会計</button>
  </footer>

</div>

</body>
</html>