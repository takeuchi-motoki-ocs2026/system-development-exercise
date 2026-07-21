
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

  <img 
    class="detail-image" 
    src="{{ asset('storage/' . $product->image) }}"
    alt="{{ $product->name }}">

  <div class="detail-info">

    <h2>{{ $product->name }}</h2>

    <p>{{ $product->price }}円</p>

  </div>

  @if($product->has_option)

  <div class="flavor">

      @foreach($product->options as $option)

          <button
              type="button"
              class="option-btn">

              {{ $option->option_name }}

          </button>

      @endforeach

  </div>

  @endif

  <div class="counter">

    <button id="minusBtn" disabled>-</button>

    <span id="count">1</span>

    <button id="plusBtn" disabled>+</button>

  </div>

  <form action="/prototype/cart/add/{{ $product->id }}" method="POST">
      @csrf

      <div class="actions">

          <input type="hidden" name="option" id="optionInput">
          <input type="hidden" name="quantity" id="quantityInput" value="1">

          <a href="{{ url('/prototype/orderHome') }}">
              <button type="button" class="back">戻る</button>
          </a>

          <button type="button" class="add" id="orderBtn" disabled>
              注文カゴに追加🛒
          </button>

      </div>
  </form>

  <footer>

    <a href="{{ url('/prototype/orderHome') }}">
      <button>注文<br>追加</button>
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

<script>
let count = 1;

const countText =
  document.getElementById("count");

const plusBtn =
  document.getElementById("plusBtn");

const minusBtn =
  document.getElementById("minusBtn");

const optionButtons =
  document.querySelectorAll(".option-btn");

let selectedOption = "";

const orderBtn =
  document.getElementById("orderBtn");

// オプションなしの商品は最初から注文可能
if(optionButtons.length === 0){

    orderBtn.disabled = false;
    plusBtn.disabled = false;

}


// オプション選択
optionButtons.forEach(button => {

    button.addEventListener("click", () => {

        optionButtons.forEach(btn =>
            btn.classList.remove("selected")
        );

        button.classList.add("selected");

        selectedOption =
            button.textContent.trim();

        count = 1;
        countText.textContent = count;

        plusBtn.disabled = false;
        minusBtn.disabled = true;
        orderBtn.disabled = false;

    });

});


// ＋
plusBtn.addEventListener("click", () => {

    if(count < 4){

        count++;

        countText.textContent = count;

        if(count >= 4){
            plusBtn.disabled = true;
        }

        if(count > 1){
            minusBtn.disabled = false;
        }

    }

});


// －
minusBtn.addEventListener("click", () => {

    if(count > 1){

        count--;

        countText.textContent = count;

        if(count <= 1){
            minusBtn.disabled = true;
        }

        if(count < 4){
            plusBtn.disabled = false;
        }

    }

});


// カート追加
orderBtn.addEventListener("click", () => {

    document.getElementById("optionInput").value =
        selectedOption;


    document.getElementById("quantityInput").value =
        count;


    document.querySelector("form").submit();

});

</script>

<script src="{{ asset('js/call-confirm.js') }}"></script>

</body>
</html>