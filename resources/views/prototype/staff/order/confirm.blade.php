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

  <div class="confirm-area">

    <h1>注文を確定しますか？</h1>

    <div class="confirm-buttons">

      <a href="{{ route('prototype.staff.order.complete') }}">
        <button>はい</button>
      </a>

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