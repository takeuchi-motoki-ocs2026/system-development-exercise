<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>注文完了</title>
  <link rel="stylesheet" href="{{ asset('css/staff_style.css') }}">
</head>
<body>

<div class="container">

  <nav class="tabs">
    <button>料理</button>
    <button>ドリンク</button>
    <button>サービス</button>
    <button>店舗限定</button>
  </nav>

  <div class="thanks-message">注文カゴに追加しました</div>

  <footer>

  </footer>

</div>

<script>
  setTimeout(() => {
    window.location.href = '{{ route('prototype.staff.order.home') }}';
  }, 1000);
</script>

</body>
</html>