<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>モバイルオーダー</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body data-detail-url="{{ url('/project/detail') }}">

<div class="container">

  <header>
    <div class="time">残り時間 60分</div>
  </header>

  <nav class="tabs">

      <button class="tab {{ $category == 'food' ? 'active' : '' }}"
          onclick="location.href='{{ url('/project/orderHome') }}?category=food&seat={{ session('seat') }}'">
          料理
      </button>

      <button class="tab {{ $category == 'drink' ? 'active' : '' }}"
          onclick="location.href='{{ url('/project/orderHome') }}?category=drink&seat={{ session('seat') }}'">
          ドリンク
      </button>

      <button class="tab {{ $category == 'service' ? 'active' : '' }}"
          onclick="location.href='{{ url('/project/orderHome') }}?category=service&seat={{ session('seat') }}'">
          サービス
      </button>

      <button class="tab {{ $category == 'limited' ? 'active' : '' }}"
          onclick="location.href='{{ url('/project/orderHome') }}?category=limited&seat={{ session('seat') }}'">
          店舗限定
      </button>

  </nav>

  <main id="menu-list">

  @foreach($products as $product)

    @php
      $price = $product->price;

      if (
          isset($course) &&
          $course === 'all_you_can_drink' &&
          $product->category === 'drink'
      ) {
          $price = 0;
      }
    @endphp

    @if($product->stock_status === '無')

      <div class="item">

        <div class="item-text">

          <h2>{{ $product->name }}</h2>

          <p>{{ $price }}円</p>

          <span class="sold-out-label">品切れ</span>

        </div>

      </div>

    @else

      <a href="{{ url('/project/detail/'.$product->id) }}?seat={{ session('seat') }}" class="item">

        <div class="item-text">

          <h2>{{ $product->name }}</h2>

          <p>{{ $price }}円</p>

        </div>

        <div class="item-image">

          <img src="{{ asset('storage/' . $product->image) }}">

        </div>

      </a>

    @endif

  @endforeach

  </main>

  <footer>

    <button type="button">
      注文<br>追加
    </button>

    <a href="{{ url('/project/cart') }}">
      <button>
        注文<br>カゴ
      </button>
    </a>

    <a href="{{ url('/project/history') }}">
      <button>
        注文<br>履歴
      </button>
    </a>

    <a href="{{ url('/project/call') }}">
      <button>
        店員<br>呼出
      </button>
    </a>

    <a href="{{ url('/project/checkout') }}">
      <button>
        会計
      </button>
    </a>

  </footer>

</div>

@include('project.partials.call-confirm')

<script src="{{ asset('js/call-confirm.js') }}"></script>

</body>
</html>