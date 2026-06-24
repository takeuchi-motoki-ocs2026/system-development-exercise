<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>商品詳細</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container">

  <header>
    <div class="time">残り時間 60分</div>
  </header>

  <nav class="tabs">

    <button class="tab active" onclick="location.href='{{ url('/prototype/orderHome') }}?category=food'">
      料理
    </button>

    <button class="tab" onclick="location.href='{{ url('/prototype/orderHome') }}?category=drink'">
      ドリンク
    </button>

    <button class="tab" onclick="location.href='{{ url('/prototype/orderHome') }}?category=service'">
      サービス
    </button>

    <button class="tab" onclick="location.href='{{ url('/prototype/orderHome') }}?category=limited'">
      店舗限定
    </button>

  </nav>

  <img class="detail-image" src="{{ asset('images/negima.jpg') }}" alt="ねぎま">

  <div class="detail-info">

    <h2>ねぎま</h2>

    <p>150円</p>

  </div>

  <div class="flavor">

    <button id="tareBtn">タレ</button>

    <button id="shioBtn">塩</button>

  </div>

  <div class="counter">

    <button id="minusBtn" disabled>-</button>

    <span id="count">1</span>

    <button id="plusBtn" disabled>+</button>

  </div>

  <div class="actions">

    <a href="{{ url('/prototype/orderHome') }}">
      <button class="back">戻る</button>
    </a>

    <button class="add" id="orderBtn" disabled>カートに追加🛒</button>

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
    if (count < 4) {
      count++;
      countText.textContent = count;

      if (count >= 4) {
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
    if (count > 0) {
      window.location.href = '{{ url('/prototype/add') }}';
    } else {
      alert('数量を選択してください');
    }
  });
</script>

@include('prototype.partials.call-confirm')

<script src="{{ asset('js/call-confirm.js') }}"></script>

</body>
</html>