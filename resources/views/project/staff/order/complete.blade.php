<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">

  <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

  <title>注文完了</title>

  <link rel="stylesheet"
    href="{{ asset('css/staff_style.css') }}">
</head>
<body>

<div class="container">

  <header>

  </header>

  <div class="thanks-message">

    注文が<br>
    完了しました

  </div>

  <footer>

  </footer>

</div>

<script>

setTimeout(() => {

  window.location.href = "{{ route('project.staff.order.home') }}";

}, 1000);

</script>
</html>
</html>