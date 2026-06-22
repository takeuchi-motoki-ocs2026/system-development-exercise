<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>削除確認</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container">

  <header>
    <div class="time">残り時間 60分</div>
  </header>

  <div class="call-area">

    <div class="call-message">
      <strong>全て削除します<br>よろしいですか？</strong>
    </div>

    <div class="confirm-buttons">

      <form action="{{ url('/prototype/cart/clear') }}" method="POST" style="display:inline">
        @csrf
        <button type="submit">はい</button>
      </form>

      <a href="{{ url('/prototype/cart') }}">
        <button>いいえ</button>
      </a>

    </div>

  </div>

  <footer>

    <a href="{{ url('/prototype/orderHome') }}">
      <button>注文</button>
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

    <a href="{{ url('/prototype/history') }}">
      <button>注文履歴</button>
    </a>

    <a href="{{ url('/prototype/call') }}">
      <button>店員呼出</button>
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