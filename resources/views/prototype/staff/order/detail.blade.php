<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>商品詳細</title>
  <link rel="stylesheet" href="{{ asset('css/staff_style.css') }}">
</head>
<body>

<div class="container">

  <header>
  </header>

  <nav class="tabs">

    <button class="tab active" onclick="location.href='{{ url('/prototype/staff/order/home') }}?category=food'">
      料理
    </button>

    <button class="tab" onclick="location.href='{{ url('/prototype/staff/order/home') }}?category=drink'">
      ドリンク
    </button>

    <button class="tab" onclick="location.href='{{ url('/prototype/staff/order/home') }}?category=service'">
      サービス
    </button>

    <button class="tab" onclick="location.href='{{ url('/prototype/staff/order/home') }}?category=limited'">
      店舗限定
    </button>

  </nav>

  <img class="detail-image" src="/images/negima.jpg" alt="ねぎま">

  <div class="detail-info">

    <h2>{{ $product->name }}</h2>

    <p>{{ $product->price }}円</p>

  </div>

  <div class="flavor">

    <button type="button" id="tareBtn">タレ</button>
    <button type="button" id="shioBtn">塩</button>

  </div>

  <div class="counter">

    <button id="minusBtn" disabled>-</button>

    <span id="count">1</span>

    <button id="plusBtn" disabled>+</button>

  </div>

  <form action="/cart/add/{{ $product->id }}" method="POST">
    @csrf

    <div class="actions">

      <input type="hidden" name="taste" id="tasteInput">
      <input type="hidden" name="quantity" id="quantityInput" value="1">

      <a href="{{ url('/prototype/staff/order/home') }}">
        <button type="button" class="back">戻る</button>
      </a>

      <button type="button" class="add" id="orderBtn">カートに追加</button>

    </div>

  </form>

  <footer>
    <a href="{{ url('/prototype/staff/order/cart') }}">
      <button>
        注文カゴ
      </button>
    </a>
    <a href="{{ url('prototype/home') }}">
      <button>
        ホーム
      </button>
    </a>
  </footer>

</div>

<script>
  let count = 1;

  const countText = document.getElementById('count');
  const plusBtn = document.getElementById('plusBtn');
  const minusBtn = document.getElementById('minusBtn');
  const tareBtn = document.getElementById('tareBtn');
  const shioBtn = document.getElementById('shioBtn');
  const orderBtn = document.getElementById('orderBtn');

  function enableCounter() {
    count = 1;
    countText.textContent = count;
    plusBtn.disabled = false;
    minusBtn.disabled = true;
    orderBtn.disabled = false;
    tareBtn.classList.remove('selected');
    shioBtn.classList.remove('selected');
  }

  tareBtn.addEventListener('click', () => {
    enableCounter();
    tareBtn.classList.add('selected');
  });

  shioBtn.addEventListener('click', () => {
    enableCounter();
    shioBtn.classList.add('selected');
  });

  plusBtn.addEventListener('click', () => {
    if (count < 5) {
      count++;
      countText.textContent = count;

      if (count >= 5) {
        plusBtn.disabled = true;
      }

      if (count > 1) {
        minusBtn.disabled = false;
      }
    }
  });

  minusBtn.addEventListener('click', () => {
    if (count > 1) {
      count--;
      countText.textContent = count;

      if (count <= 1) {
        minusBtn.disabled = true;
      }

      if (count < 4) {
        plusBtn.disabled = false;
      }
    }
  });

  orderBtn.addEventListener('click', () => {
    if (!tareBtn.classList.contains('selected') && !shioBtn.classList.contains('selected')) {
      alert('味を選択してください');
      return;
    }

    if (count > 0) {

      const taste = tareBtn.classList.contains('selected') ? 'タレ' : '塩';

      document.getElementById('tasteInput').value = taste;
      document.getElementById('quantityInput').value = count;

      document.querySelector('form').submit();

    } else {
      alert('数量を選択してください');
    }
  });
</script>

</body>
</html>