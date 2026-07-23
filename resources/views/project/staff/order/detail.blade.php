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

    <button class="tab active" onclick="location.href='{{ url('/project/staff/order/home') }}?category=food'">
      料理
    </button>

    <button class="tab" onclick="location.href='{{ url('/project/staff/order/home') }}?category=drink'">
      ドリンク
    </button>

    <button class="tab" onclick="location.href='{{ url('/project/staff/order/home') }}?category=service'">
      サービス
    </button>

    <button class="tab" onclick="location.href='{{ url('/project/staff/order/home') }}?category=limited'">
      店舗限定
    </button>

  </nav>

  <img
    class="detail-image"
    src="{{ asset('storage/' . $product->image) }}"
    alt="{{ $product->name }}"
  >

  <div class="detail-info">

    <h2>{{ $product->name }}</h2>

    <p>
    @if(isset($course) && $course === 'all_you_can_drink' && $product->category === 'drink')
        0円
    @else
        {{ $product->price }}円
    @endif
    </p>

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

  <form action="/cart/add/{{ $product->id }}" method="POST">
    @csrf

    <div class="actions">

      <input type="hidden" name="option" id="optionInput">
      <input type="hidden" name="quantity" id="quantityInput" value="1">

      <a href="{{ url('/project/staff/order/home') }}">
        <button type="button" class="back">戻る</button>
      </a>

      <button type="button" class="add" id="orderBtn" disabled>
          注文カゴに追加🛒
      </button>

    </div>

  </form>

  <footer>
    <a href="{{ url('/project/staff/order/cart') }}">
      <button>
        注文カゴ
      </button>
    </a>
    <a href="{{ url('project/home') }}">
      <button>
        ホーム
      </button>
    </a>
  </footer>

</div>

<script>
  let count = 1;

  const optionButtons = document.querySelectorAll('.option-btn');
  let selectedOption = '';
  optionButtons.forEach(button => {

    button.addEventListener(
        'click',
        () => {

            optionButtons.forEach(btn =>
                btn.classList.remove(
                    'selected'
                )
            );

            button.classList.add(
                'selected'
            );

            selectedOption =
                button.textContent.trim();

            enableCounter();
        }
    );

});
  const countText = document.getElementById('count');
  const plusBtn = document.getElementById('plusBtn');
  const minusBtn = document.getElementById('minusBtn');
  const orderBtn = document.getElementById('orderBtn');

  if (optionButtons.length === 0) {

    plusBtn.disabled = false;

    orderBtn.disabled = false;
}

  function enableCounter() {
    count = 1;

    countText.textContent = count;

    plusBtn.disabled = false;

    minusBtn.disabled = true;

    orderBtn.disabled = false;
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

  orderBtn.addEventListener(
    'click',
    () => {

        if (
            optionButtons.length > 0 &&
            selectedOption === ''
        ) {

            alert(
                'オプションを選択してください'
            );

            return;
        }

        document.getElementById(
            'optionInput'
        ).value =
            selectedOption;

        document.getElementById(
            'quantityInput'
        ).value =
            count;

        document
            .querySelector('form')
            .submit();
    }
);
</script>

</body>
</html>