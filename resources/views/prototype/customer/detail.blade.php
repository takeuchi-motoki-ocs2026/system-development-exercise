@php
  $itemKey = request('item', 'negima');
  $products = [
    'negima' => ['name' => 'ねぎま', 'price' => '150円', 'image' => '/images/negima.jpg', 'alt' => 'ねぎま', 'hasFlavor' => true, 'flavors' => ['タレ', '塩', 'みそ']],
    'momo' => ['name' => 'もも', 'price' => '150円', 'image' => '/images/momo.jpg', 'alt' => 'もも', 'hasFlavor' => true, 'flavors' => ['タレ', '塩',]],
    'seseri' => ['name' => 'せせり', 'price' => '150円', 'image' => '/images/seseri.jpg', 'alt' => 'せせり', 'hasFlavor' => true, 'flavors' => ['タレ', '塩']],
    'beer' => ['name' => '生ビール', 'price' => '500円', 'image' => '/images/beer.jpg', 'alt' => '生ビール', 'hasFlavor' => false, 'flavors' => []],
    'highball' => ['name' => 'ハイボール', 'price' => '450円', 'image' => '/images/highball.jpg', 'alt' => 'ハイボール', 'hasFlavor' => false, 'flavors' => []],
    'towel' => ['name' => 'おしぼり', 'price' => '無料', 'image' => '/images/towel.jpg', 'alt' => 'おしぼり', 'hasFlavor' => false, 'flavors' => []],
    'plate' => ['name' => '取り皿', 'price' => '無料', 'image' => '/images/plate.jpg', 'alt' => '取り皿', 'hasFlavor' => false, 'flavors' => []],
    'limited' => ['name' => '限定串', 'price' => '300円', 'image' => '/images/limited.jpg', 'alt' => '限定串', 'hasFlavor' => false, 'flavors' => []],
  ];
  $product = $products[$itemKey] ?? $products['negima'];
@endphp


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

  <img class="detail-image" src="{{ asset($product['image']) }}" alt="{{ $product['alt'] }}">

  <div class="detail-info">

    <h2>{{ $product['name'] }}</h2>

    <p>{{ $product['price'] }}</p>

  </div>

  @if($product['hasFlavor'])
    <div class="flavor">
      @foreach($product['flavors'] as $index => $flavor)
        <button class="flavor-btn" id="flavorBtn{{ $index }}">{{ $flavor }}</button>
      @endforeach
    </div>
  @endif

  <div class="counter">

    <button id="minusBtn" disabled>-</button>

    <span id="count">1</span>

    <button id="plusBtn" disabled>+</button>

  </div>

  <div class="actions">

    <a href="{{ url('/prototype/orderHome') }}">
      <button class="back">戻る</button>
    </a>

    <button class="add" id="orderBtn" disabled>注文カゴに追加🛒</button>

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
  const orderBtn = document.getElementById('orderBtn');
  const hasFlavor = {{ $product['hasFlavor'] ? 'true' : 'false' }};
  const flavorButtons = Array.from(document.querySelectorAll('.flavor-btn'));

  function resetFlavorSelection() {
    flavorButtons.forEach((button) => button.classList.remove('selected'));
  }

  function enableCounter() {
    count = 1;
    countText.textContent = count;
    plusBtn.disabled = false;
    minusBtn.disabled = true;
    orderBtn.disabled = false;
    if (hasFlavor) {
      resetFlavorSelection();
    }
  }

  if (hasFlavor) {
    flavorButtons.forEach((button) => {
      button.addEventListener('click', () => {
        enableCounter();
        resetFlavorSelection();
        button.classList.add('selected');
      });
    });
  } else {
    enableCounter();
  }

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