<!DOCTYPE html>
<html lang="ja">
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
  <nav class="tabs">
    <button>料理</button>
    <button>ドリンク</button>
    <button>サービス</button>
    <button>店舗限定</button>
  </nav>

  <div class="confirm-area">

    <h1>注文を確定しますか？</h1>

    <div class="confirm-buttons">

      <a href="{{ url('/prototype/complete') }}">
        <button>はい</button>
      </a>

      <a href="{{ url('/prototype/cart') }}">
        <button>いいえ</button>
      </a>

    </div>

  </div>

  <footer>

    <a href="{{ url('/prototype/orderHome') }}">
      <button>注文</button>
    </a>

    <a href="{{ url('/prototype/cart') }}">
      <button>注文カゴ</button>
    </a>

    <a href="{{ url('/prototype/history') }}">
      <button>注文履歴</button>
    </a>

    <a href="{{ url('/prototype/call') }}">
      <button>店員呼出</button>
    </a>

    <a href="{{ url('/prototype/checkout') }}">
      <button>会計</button>
    </a>

  </footer>

</div>

@include('prototype.partials.call-confirm')

<script src="{{ asset('js/call-confirm.js') }}"></script>

</body>
</html>