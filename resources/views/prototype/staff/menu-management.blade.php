<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>メニュー管理</title>

<style>
body {
    margin: 0;
    font-family: sans-serif;
    background-color: #e6b98a;

    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

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

.container {
    flex: 1;
    padding: 10px;
}

h2 {
    margin: 15px 0;
}

/* ===== メニューボタン ===== */

.menu-btn {

    width: 100%;

    padding: 35px 10px;

    margin-bottom: 15px;

    background-color: #ddd594;

    border: 1px solid #c4b66d;

    font-size: 20px;

    text-align: center;

    box-sizing: border-box;

    cursor: pointer;
}

.menu-btn:active {

    background-color: #cfc57f;
}

/* ===== 戻るボタン ===== */

.back-btn {

    margin-top: 20px;

    width: 120px;

    padding: 12px;

    background-color: #35c3e6;

    color: white;

    border: 1px solid #666;

    font-size: 20px;

    cursor: pointer;
}
</style>
</head>

<body>

<div class="header"></div>

<div class="container">

    <h2>メニュー管理</h2>

    <!-- 在庫状況 -->

    <div class="menu-btn" onclick="location.href='{{ route('prototypestock-status') }}'">
        在庫状況
    </div>

    <!-- メニュー追加 -->

    <div class="menu-btn"
        onclick="location.href='{{ route('prototypemenu-add') }}'">

        メニュー追加

    </div>

    <!-- メニュー編集 -->

    <div class="menu-btn"
        onclick="location.href='{{ route('prototypemenu-edit-list') }}'">

        メニュー編集一覧

    </div>

    <!-- 戻る -->

    <button class="back-btn"
        onclick="location.href='{{ route('prototypehome') }}'">

        戻る

    </button>

</div>

<div class="footer">

    <button class="home-icon-btn"
        onclick="location.href='{{ route('prototypehome') }}'">

        ⌂

    </button>

</div>

</body>
</html>