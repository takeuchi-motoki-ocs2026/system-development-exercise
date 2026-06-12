<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport"
    content="width=device-width, initial-scale=1.0">

<title>メニュー編集</title>

<style>

body {

    margin: 0;

    font-family: sans-serif;

    background-color: #e6b98a;

    display: flex;

    flex-direction: column;

    min-height: 100vh;
}

/* ===== モーダル中スクロールロック ===== */

body.modal-open {

    overflow: hidden;
}

/* ===== ヘッダー・フッター ===== */

.header,
.footer {
    height: 80px;
    background-color: #e0663f;

    display: flex;
    justify-content: center;
    align-items: center;
}

.home-icon-btn {
    width: 70px;
    height: 70px;

    border: none;
    border-radius: 20px;

    background-color: #d9d9d9;

    font-size: 42px;
    color: #444;

    display: flex;
    justify-content: center;
    align-items: center;

    box-shadow:
        inset 0 2px 4px rgba(255,255,255,0.7),
        0 2px 5px rgba(0,0,0,0.2);
}

/* ===== コンテンツ ===== */

.container {

    flex: 1;

    padding: 10px;
}

h2 {

    margin: 15px 0;

    font-size: 24px;
}

/* ===== 画像エリア ===== */

.image-box {

    width: 100%;

    height: 140px;

    background-color: #eee;

    border: 1px solid #ccc;

    display: flex;

    align-items: center;

    justify-content: center;

    color: #555;

    margin-bottom: 15px;

    box-sizing: border-box;

    overflow: hidden;

    position: relative;

    cursor: pointer;
}

.image-box img {

    width: 100%;

    height: 100%;

    object-fit: contain;

    object-position: center;

    background-color: #eee;
}

.image-box span {

    position: absolute;
}

/* ===== 入力欄 ===== */

.input-box {

    width: 100%;

    padding: 15px 10px;

    margin-bottom: 10px;

    border: 1px solid #c4b66d;

    background-color: #ddd594;

    box-sizing: border-box;

    font-size: 18px;

    display: flex;

    align-items: center;

    gap: 10px;
}

.input-box input {

    flex: 1;

    min-width: 0;

    border: none;

    background: transparent;

    font-size: 18px;

    outline: none;
}

/* ===== ボタンエリア ===== */

.button-area {

    display: flex;

    justify-content: space-between;

    margin-top: 20px;
}

/* ===== 戻るボタン ===== */

.back-btn {

    width: 90px;

    padding: 12px;

    background-color: #35c3e6;

    color: white;

    border: 1px solid #666;

    font-size: 20px;

    cursor: pointer;
}

/* ===== 編集ボタン ===== */

.edit-btn {

    width: 90px;

    padding: 12px;

    background-color: red;

    color: white;

    border: none;

    font-size: 20px;

    cursor: pointer;
}

/* ===== モーダル ===== */

.modal {

    display: none;

    position: fixed;

    top: 0;
    left: 0;

    width: 100%;
    height: 100%;

    background-color: rgba(0,0,0,0.2);

    justify-content: center;

    align-items: center;

    z-index: 9999;
}

.modal-content {

    width: 90%;

    max-width: 320px;

    background-color: #eee;

    border: 1px solid #666;

    padding: 15px;

    box-sizing: border-box;
}

.modal-title {

    font-size: 14px;

    margin-bottom: 15px;
}

.modal-message {

    border: 1px solid #888;

    background-color: white;

    padding: 15px;

    text-align: center;

    margin-bottom: 15px;
}

/* ===== モーダルボタン ===== */

.modal-buttons {

    display: flex;

    justify-content: flex-end;

    gap: 10px;
}

/* ===== キャンセル ===== */

.cancel-btn {

    width: 80px;

    background-color: #888;

    color: white;

    border: none;

    padding: 6px;

    cursor: pointer;
}

/* ===== 編集 ===== */

.ok-btn {

    width: 80px;

    background-color: red;

    color: white;

    border: none;

    padding: 6px;

    cursor: pointer;
}

/* ===== numberの↑↓を消す ===== */

input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {

    -webkit-appearance: none;

    margin: 0;
}

</style>
</head>

<body>

<!-- ===== ヘッダー ===== -->

<div class="header"></div>

<!-- ===== コンテンツ ===== -->

<div class="container">

    <h2>メニュー編集</h2>

    <!-- ===== 画像 ===== -->

    <div class="image-box"
        onclick="document.getElementById('imageInput').click()">

        <img id="preview"
            style="display:none;">

        <span id="imageText">

            写真

        </span>

    </div>

    <!-- ===== ファイル選択 ===== -->

    <input type="file"
        id="imageInput"
        accept="image/*"
        capture="environment"
        style="display:none"
        onchange="previewImage(event)">

    <!-- ===== 商品名 ===== -->

    <div class="input-box">

        <span>商品名：</span>

        <input type="text"
            id="menuName">

    </div>

    <!-- ===== 値段 ===== -->

    <div class="input-box">

        <span>値段：</span>

        <input type="number"
            id="menuPrice">

    </div>

    <!-- ===== ボタン ===== -->

    <div class="button-area">

        <!-- ===== 戻る ===== -->

        <button class="back-btn"
            onclick="location.href='{{ route('prototypemenu-edit-list') }}'">

            戻る

        </button>

        <!-- ===== 編集 ===== -->

        <button class="edit-btn"
            onclick="openModal()">

            編集

        </button>

    </div>

</div>

<!-- ===== フッター ===== -->

<div class="footer">

    <button class="home-icon-btn"
        onclick="location.href='{{ route('prototypehome') }}'">

        ⌂

    </button>

</div>

<!-- ===== モーダル ===== -->

<div class="modal"
    id="modal">

    <div class="modal-content">

        <!-- ===== タイトル ===== -->

        <div class="modal-title">

            確認

        </div>

        <!-- ===== メッセージ ===== -->

        <div class="modal-message">

            本当に編集しますか？

        </div>

        <!-- ===== ボタン ===== -->

        <div class="modal-buttons">

            <!-- ===== キャンセル ===== -->

            <button class="cancel-btn"
                onclick="closeModal()">

                キャンセル

            </button>

            <!-- ===== 編集 ===== -->

            <button class="ok-btn"
                onclick="completeEdit()">

                編集

            </button>

        </div>

    </div>

</div>

<script>

/* ===== 画像プレビュー ===== */

function previewImage(event) {

    const file =
        event.target.files[0];

    if(!file) return;

    const reader =
        new FileReader();

    reader.onload = function(e) {

        document.getElementById("preview").src =
            e.target.result;

        document.getElementById("preview").style.display =
            "block";

        document.getElementById("imageText").style.display =
            "none";
    }

    reader.readAsDataURL(file);
}

/* ===== モーダル表示 ===== */

function openModal() {

    document.getElementById("modal").style.display =
        "flex";

    document.body.classList.add(
        "modal-open"
    );
}

/* ===== モーダル閉じる ===== */

function closeModal() {

    document.getElementById("modal").style.display =
        "none";

    document.body.classList.remove(
        "modal-open"
    );
}

/* ===== 編集 ===== */

function completeEdit() {

    alert("編集しました");

    closeModal();
}

</script>

</body>
</html>