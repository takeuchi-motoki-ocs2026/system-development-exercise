<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport"
    content="width=device-width, initial-scale=1.0">

<title>メニュー追加</title>

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

.back-btn {

    width: 90px;

    padding: 12px;

    background-color: #35c3e6;

    color: white;

    border: 1px solid #666;

    font-size: 20px;

    cursor: pointer;
}

.add-btn {

    width: 90px;

    padding: 12px;

    background-color: red;

    color: white;

    border: none;

    font-size: 20px;

    cursor: pointer;
}

.add-btn:disabled {

    background-color: #aaa;

    cursor: not-allowed;

    opacity: 0.6;
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

.modal-buttons {

    display: flex;

    justify-content: flex-end;

    gap: 10px;
}

.cancel-btn {

    width: 80px;

    background-color: #888;

    color: white;

    border: none;

    padding: 6px;

    cursor: pointer;
}

.ok-btn {

    width: 80px;

    background-color: red;

    color: white;

    border: none;

    padding: 6px;

    cursor: pointer;
}

/* ===== numberの↑↓削除 ===== */

input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {

    -webkit-appearance: none;

    margin: 0;
}

</style>
</head>

<body>

<div class="header"></div>

<div class="container">

    
    <form action="/menu/add" method="POST" enctype="multipart/form-data">
        @csrf


        <h2>メニュー追加</h2>

        <div class="image-box"
            onclick="document.getElementById('imageInput').click()">

            <img id="preview" style="display:none;">

            <span id="imageText">写真の追加</span>

        </div>

        <input type="file"
            id="imageInput"
            name="image"
            accept="image/*"
            style="display:none"
            onchange="previewImage(event)">

        <div class="input-box">

            <span>商品名：</span>

            <input type="text" id="menuName" name="name">

        </div>

        <div class="input-box">

            <span>値段：</span>

            <input type="number" id="menuPrice" name="price">

        </div>

        <div class="input-box">

            <span>カテゴリ：</span>

            <select name="category">

                <option value="food">料理</option>

                <option value="drink">ドリンク</option>

                <option value="service">サービス</option>

                <option value="limited">店舗限定</option>

            </select>

        </div>

        <div class="button-area">

            <button class="back-btn" type="button"
                onclick="window.location.href='{{ route('prototypemenu-management') }}'">

                戻る

            </button>

            <button class="add-btn" id="addBtn" type="submit">

                追加

            </button>

        </div>
    </form>
</div>

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

        <div class="modal-title">

            確認

        </div>

        <div class="modal-message">

            本当に追加しますか？

        </div>

        <div class="modal-buttons">

            <button class="cancel-btn"
                onclick="closeModal()">

                キャンセル

            </button>

            <button class="ok-btn"
                onclick="addMenu()">

                追加

            </button>

        </div>

    </div>

</div>

<script>

/* ===== 画像プレビュー ===== */

function previewImage(event) {

    const file = event.target.files[0];

    if(!file) return;

    const reader = new FileReader();

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

/* ===== 入力チェック ===== */

const nameInput =
    document.getElementById("menuName");

const priceInput =
    document.getElementById("menuPrice");

const addBtn =
    document.getElementById("addBtn");

function checkInput() {

    addBtn.disabled = !(
        nameInput.value.trim() !== "" &&
        priceInput.value.trim() !== ""
    );
}

nameInput.addEventListener(
    "input",
    checkInput
);

priceInput.addEventListener(
    "input",
    checkInput
);

window.onload = function() {

    addBtn.disabled = true;
};

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

/* ===== 追加処理 ===== */

function addMenu() {

    alert("追加しました");

    closeModal();
}

</script>

</body>
</html>