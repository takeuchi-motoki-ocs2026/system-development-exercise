<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">

  <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

  <title>注文完了</title>

  <link rel="stylesheet"
    href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container">

  <header>
    <div class="time">残り時間 60分</div>
  </header>

  <nav class="tabs">
    <button>料理</button>
    <button>ドリンク</button>
    <button>サービス</button>
    <button>店舗限定</button>
  </nav>

  <div class="thanks-message">

    ご注文<br>
    ありがとうございます

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

<script>
  setTimeout(() => {
    window.location.href = "{{ url('/prototype/orderHome') }}";
  }, 1000);
</script>

</body>
</html>