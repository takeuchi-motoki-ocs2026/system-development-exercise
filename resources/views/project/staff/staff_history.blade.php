<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>注文履歴</title>

<style>
body {
    margin: 0;
    font-family: sans-serif;
    background-color: #f4c99b;
    display: flex;
    flex-direction: column;
    height: 100vh;
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

    display: flex;
    flex-direction: column;

    overflow: hidden;

    min-height: 0;

    padding: 10px;
}

h2 {
    margin: 0;
    font-size: 32px;
    text-align: left;
}

.history-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.seat-label {
    font-size: 26px;
    color: #5d4524;
}

.history-list {
    flex: 1;
    overflow-y: auto;
    min-height: 0;
    padding-bottom: 70px;

    scrollbar-width: none;
}

.history-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px;
    margin-bottom: 15px;
    background-color: #e5df9c;
    border: 1px solid #c4b66d;
    border-radius: 6px;
    box-sizing: border-box;
}

.history-info {
    display: flex;
    flex-direction: column;
}

.item-name {
    margin: 0;
    font-size: 18px;
    font-weight: bold;
}

.item-price {
    margin: 4px 0 0;
    font-size: 16px;
    color: #5d4524;
}

.item-count {
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background-color: #999999;
    color: white;
    font-size: 18px;
    font-weight: bold;
    flex-shrink: 0;
}

.button-area {
    height: 70px;
    flex-shrink: 0;
}

.back-btn {

    position: fixed;
    bottom: 90px;
    left: 10px;

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

    <div class="history-header">
        <h2>注文履歴</h2>
        <div class="seat-label">{{ $seat }}席</div>
    </div>

    <div class="history-list">

    @foreach($orders as $order)

    <div class="history-item">

        <div class="history-info">

            <p class="item-name">
                {{ $order->name }}（{{ $order->taste ?? '' }}）
            </p>

            <p class="item-price">
                {{ $order->price }}円
            </p>

        </div>

        <div class="item-count">
            {{ $order->quantity }}
        </div>

    </div>

    @endforeach

    </div>

    <div class="button-area">
        <button class="back-btn"
            onclick="location.href='{{ route('projectorder-history') }}'">

            戻る

        </button>
    </div>

</div>

<div class="footer">

    <button class="home-icon-btn"
        onclick="location.href='{{ route('projecthome') }}'">

        ⌂

    </button>

</div>

</body>
</html>