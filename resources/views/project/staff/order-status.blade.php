<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>注文状況</title>

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

/* ===== テーブル ===== */

table {
    width: 100%;
    border-collapse: collapse;
    background-color: white;
}

th,
td {
    border: 1px solid #666;
    text-align: center;
    padding: 10px 5px;
    font-size: 14px;
}

th {
    background-color: #999;
    color: white;
    height:50px;
}

tbody tr {
    height: 50px;
}

/* 押せるセル */

.clickable {
    cursor: pointer;
    background-color: #fff;
}

.clickable:active {
    background-color: #ddd;
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
}

/* ===== モーダル ===== */

.modal {
    display: none;

    position: fixed;
    top: 0;
    left: 0;

    width: 100%;
    height: 100%;

    background-color: rgba(0,0,0,0.3);

    justify-content: center;
    align-items: center;
}

.modal-content {

    width: 90%;
    max-width: 320px;

    background-color: #eee;
    border: 1px solid #666;

    padding: 15px;
}

.modal-content p {
    margin: 15px 0;
}

.count-area {

    display: flex;
    align-items: center;
    justify-content: center;

    gap: 10px;

    margin-top: 20px;
}

.count-btn {

    width: 40px;
    height: 40px;

    font-size: 22px;
}

.change-btn {

    margin-top: 20px;

    width: 100%;
    padding: 10px;

    background-color: red;
    color: white;

    border: none;
}

</style>
</head>

<body>

<div class="header"></div>

<div class="container">

    <h2>注文状況</h2>

    <table>

        <thead>
            <tr>
                <th>席番号</th>
                <th>商品名</th>
                <th>注文個数</th>
                <th>配膳数</th>
            </tr>
        </thead>
        
        <tbody>

        @foreach($orders as $order)

        <tr data-id="{{ $order->id }}">

            <td>{{ $order->seat }}</td>

            <td>{{ $order->name }}</td>

            <td class="count clickable"
                onclick="openModal(this, 'order')">

                {{ $order->quantity }}

            </td>

            <td class="served clickable"
                onclick="openModal(this, 'served')">

                {{ $order->served_quantity ?? 0 }}

            </td>

        </tr>

        @endforeach

        </tbody>

    </table>

    <button class="back-btn"
        onclick="location.href='/project/order-menu'">

        戻る

    </button>

</div>

<div class="footer">

    <button class="home-icon-btn"
        onclick="location.href='/project/home'">

        ⌂

    </button>

</div>

<!-- ===== モーダル ===== -->

<div class="modal" id="modal">

    <div class="modal-content">

        <p id="seatText">席番号：</p>

        <p id="itemText">商品：</p>

        <p id="modeText"></p>

        <div class="count-area">

            <button class="count-btn"
                onclick="decreaseCount()">

                −

            </button>

            <span id="modalCount">1</span>

            <button class="count-btn"
                onclick="increaseCount()">

                ＋

            </button>

        </div>

        <button class="change-btn"
            onclick="changeCount()">

            変更

        </button>

    </div>

</div>

<script>

let currentCell = null;

let currentOrderId = null;

let currentCount = 1;

let currentMode = "";

let maxOrderCount = 0;

/* ===== モーダルを開く ===== */

function openModal(cell, mode) {

    currentCell = cell;

    currentOrderId = cell.parentElement.dataset.id;

    currentMode = mode;

    const row = cell.parentElement;

    const seat =
        row.cells[0].innerText;

    const item =
        row.cells[1].innerText;

    maxOrderCount =
        Number(row.cells[2].innerText);
    
    currentCount =
        Number(cell.innerText);

    document.getElementById("seatText").innerText =
        "席番号：" + seat;

    document.getElementById("itemText").innerText =
        "商品：" + item;

    if(mode === "order") {

        document.getElementById("modeText").innerText =
            "注文個数";
    }
    else {

        document.getElementById("modeText").innerText =
            "配膳個数";
    }

    document.getElementById("modalCount").innerText =
        currentCount;

    document.getElementById("modal").style.display =
        "flex";
}

/* ===== ＋ ===== */

function increaseCount() {

    if(currentMode === "served")
    {
        if(currentCount < maxOrderCount)
        {
            currentCount++;
        }
    }
    else
    {
        currentCount++;
    }

    document.getElementById("modalCount").innerText =
        currentCount;
}

/* ===== − ===== */

function decreaseCount() {

    if(currentMode === "order") {

        if(currentCount > 1) {

            currentCount--;
        }
    }
    else {

        if(currentCount > 0) {

            currentCount--;
        }
    }

    document.getElementById("modalCount").innerText =
        currentCount;
}

/* ===== 変更 ===== */
function changeCount()
{
    fetch(
        "/order-status/update/" + currentOrderId,
        {
            method: "POST",

            headers: {
                "Content-Type":
                    "application/json",

                "X-CSRF-TOKEN":
                    "{{ csrf_token() }}"
            },

            body: JSON.stringify({
                served_quantity:
                    currentCount
            })
        }
    )
    .then(response => response.json())
    .then(data => {

        currentCell.innerText =
            currentCount;

        const row =
            currentCell.parentElement;

        const orderCount =
            Number(row.cells[2].innerText);

        const servedCount =
            Number(row.cells[3].innerText);

        if(orderCount === servedCount)
        {
            row.remove();
        }

        document.getElementById("modal").style.display =
            "none";
    });
}

/* ===== モーダル外クリック ===== */

window.onclick = function(event) {

    const modal =
        document.getElementById("modal");

    if(event.target == modal) {

        modal.style.display = "none";
    }
}
</script>

</body>
</html>