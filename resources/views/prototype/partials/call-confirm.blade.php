<div id="call-confirm-overlay" class="cc-overlay" style="display:none">
  <div class="cc-modal" role="dialog" aria-modal="true" aria-labelledby="cc-title">

    <p id="cc-title" class="cc-title">
      店員を呼び出しますか？
    </p>

    <div class="cc-actions">

      <button
        type="button"
        id="cc-cancel"
        class="cc-btn cc-cancel">
        キャンセル
      </button>

      <form action="{{ route('prototype.call.store') }}" method="POST">
        @csrf

        <button
          type="submit"
          id="cc-ok"
          class="cc-btn cc-ok">
          OK
        </button>
      </form>

    </div>
  </div>
</div>