<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>モバイルオーダー</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container">

  @if(session('success'))
    <div id="msg" style="background: lightgreen; padding: 10px; text-align:center;">
      {{ session('success') }}
    </div>

    <script>
      // 2秒で消す
      setTimeout(() => {
        const msg = document.getElementById('msg');
        if (msg) msg.style.display = 'none';
      }, 2000);
    </script>
  @endif

  <header>
  </header>

  <nav class="tabs">

    <button class="tab active" onclick="showMenu('food', event)">
      料理
    </button>

    <button class="tab" onclick="showMenu('drink', event)">
      ドリンク
    </button>

    <button class="tab" onclick="showMenu('service', event)">
      サービス
    </button>

    <button class="tab" onclick="showMenu('limited', event)">
      店舗限定
    </button>
    
  </nav>

  <main id="menu-list">

      
      @foreach ($products as $product)

          <a href="/prototype/staff/order/detail/{{ $product->id }}" class="item">

              <div class="item-text">
                  <h2>{{ $product->name }}</h2>
                  <p>{{ $product->price }}円</p>
              </div>

          </a>

      @endforeach


  </main>

  <footer>
    <a href="{{ url('/prototype/staff/order/cart') }}">
      <button>注文カゴ</button>
    </a>
    <a href="{{ url('prototype/home') }}">
      <button>
        ホーム
      </button>
    </a>
  </footer>

</div>



</body>
</html>