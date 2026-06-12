<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">

  <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

  <title>注文確認</title>

  <link rel="stylesheet"
    href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container">

  <header>

  </header>

  <nav class="tabs">
    <button>料理</button>
    <button>ドリンク</button>
    <button>サービス</button>
    <button>店舗限定</button>
  </nav>

  <div class="confirm-area">

    <h1>
      全て削除します<br>
      よろしいですか？
    </h1>

    <div class="confirm-buttons">

      <a href="{{ route('prototype.staff.order.cart') }}">
          <form action="{{ route('prototype.staff.order.cart.clear') }}" method="POST" style="display:inline">
            @csrf
            <button type="submit">はい</button>
          </form>

      <a href="{{ route('prototype.staff.order.cart') }}">
        <button>いいえ</button>
      </a>

    </div>

  </div>

  <footer>

  </footer>

</div>

</body>
</html>