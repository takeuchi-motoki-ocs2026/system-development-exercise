<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>座席管理</title>

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

/* ===== 座席セル ===== */

.seat-cell {
    cursor: pointer;
    font-size: 16px;
}

.use-seat:hover {
    background: #e8e8e8;
}

/* ===== 状態プルダウン ===== */

.status-select {

    width: 100%;

    border: none;

    background-color: white;

    font-size: 14px;

    text-align: center;
}

.status-select:disabled {
    background-color: white;
    color: #666;
}

.status-cell {
    position: relative;
    padding: 0;
}

.call-dot {
    position: absolute;
    top: 3px;
    right: 3px;

    width: 12px;
    height: 12px;

    background-color: red;
    border-radius: 50%;

    font-size: 0;
    z-index: 10;
    pointer-events: none;
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

/* ===== モーダル ===== */

.modal {

    display: none;

    position: fixed;

    top: 0;
    left: 0;

    width: 100%;
    height: 100%;

    background: rgba(0,0,0,0.3);

    justify-content: center;
    align-items: center;
}

.modal-box {

    width: 320px;

    background: #eee;

    border: 1px solid #333;

    padding: 15px;
}

.modal-title {
    font-size: 16px;
    margin-bottom: 15px;
}

.modal-message {

    background: white;

    border: 1px solid #666;

    padding: 20px;

    text-align: center;

    font-size: 16px;

    margin-bottom: 15px;
}

.modal-buttons {

    display: flex;

    justify-content: flex-end;

    gap: 10px;
}

.no-btn {

    width: 90px;
    height: 32px;

    background: #999;

    color: white;

    border: 1px solid #555;

    cursor: pointer;
}

.yes-btn {

    width: 70px;
    height: 32px;

    background: red;

    color: white;

    border: 1px solid #555;

    cursor: pointer;
}

</style>
</head>

<body>

<div class="header"></div>

<div class="container">

<h2>座席管理</h2>

<table>

    <thead>
        <tr>
            <th>席番号</th>
            <th>定員</th>
            <th>座席</th>
            <th>状態</th>
        </tr>
    </thead>

    <tbody>

    @foreach($tables as $table)

    @php
        $hasCall = $calls->contains('table_id', $table->table_id);
    @endphp

    <tr data-id="{{ $table->table_id }}">

        <td>{{ $table->table_number }}</td>

        <td>{{ $table->max_people }}</td>

        <td
            class="seat-cell {{ $table->seat_status === 'occupied' ? 'use-seat' : '' }}"
            onclick="openConfirm(this)">

            {{ $table->seat_status === 'occupied' ? '使' : '空' }}

        </td>

        <td class="status-cell">

            @if($hasCall)
                <span class="call-dot">●</span>
            @endif

            <select
                class="status-select"
                onchange="updateCallStatus(this)"
                {{ $table->seat_status === 'available' ? 'disabled' : '' }}>

                <option></option>
                <option value="processing">対応中</option>
                <option value="payment">会計待ち</option>
                <option value="cleaning">掃除</option>
            </select>

        </td>

    </tr>

    @endforeach

    </tbody>

</table>

<button class="back-btn"
    onclick="location.href='/prototype/home'">
    戻る
</button>

</div>

<div class="footer">

    <button class="home-icon-btn"
        onclick="location.href='/prototype/home'">

        ⌂

    </button>

</div>

<!-- ===== モーダル ===== -->

<div id="confirmModal" class="modal">

    <div class="modal-box">

        <div class="modal-title">
            確認
        </div>

        <div class="modal-message">
            本当に空席にしますか？
        </div>

        <div class="modal-buttons">

            <button class="no-btn"
                onclick="closeModal()">
                いいえ
            </button>

            <button class="yes-btn"
                onclick="changeToEmpty()">
                はい
            </button>

        </div>

    </div>

</div>

<script>

let selectedSeat = null;

function openConfirm(cell){

    if(cell.innerText !== "使"){
        return;
    }

    selectedSeat = cell;

    document.getElementById("confirmModal")
        .style.display = "flex";
}

function closeModal(){

    document.getElementById("confirmModal")
        .style.display = "none";
}

function changeToEmpty(){

    if(selectedSeat){

        selectedSeat.innerText = "空";

        selectedSeat.classList.remove("use-seat");

        const row = selectedSeat.parentElement;

        const status = row.querySelector(".status-select");

        if(status){

            status.selectedIndex = 0;
            status.disabled = true;
        }

        const seatNo = row.cells[0].innerText;

        const tableId = row.dataset.id;

        fetch(
            "/seat/empty/" + tableId,
            {
                method: "POST",

                headers: {
                    "X-CSRF-TOKEN":
                        "{{ csrf_token() }}"
                }
            }
        )
        .then(() => {

            selectedSeat.innerText = "空";

            selectedSeat.classList.remove("use-seat");

            status.selectedIndex = 0;

            status.disabled = true;
        });
    }

    closeModal();
}
function updateCallStatus(select){

    if(select.value !== "processing"){
        return;
    }

    const row = select.closest("tr");
    const tableId = row.dataset.id;

    fetch("/call/" + tableId + "/processing", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json"
        }
    })
    .then(response => {
        if(!response.ok){
            throw new Error("更新に失敗しました");
        }

        const dot = row.querySelector(".call-dot");

        if(dot){
            dot.remove();
        }
    })
    .catch(error => {
        alert(error.message);
    });
}

function checkPendingCalls(){

    fetch("{{ route('prototype.call.pending-check') }}")
        .then(response => {
            if(!response.ok){
                throw new Error("通知の取得に失敗しました");
            }

            return response.json();
        })
        .then(data => {

            const pendingTables = data.tables.map(Number);

            document.querySelectorAll("tbody tr").forEach(row => {

                const tableId = Number(row.dataset.id);
                const statusCell = row.querySelector(".status-cell");
                const currentDot = statusCell.querySelector(".call-dot");

                if(pendingTables.includes(tableId)){

                    if(!currentDot){
                        const dot = document.createElement("span");
                        dot.classList.add("call-dot");
                        dot.textContent = "●";

                        statusCell.appendChild(dot);
                    }

                }else{

                    if(currentDot){
                        currentDot.remove();
                    }
                }
            });
        })
        .catch(error => {
            console.error(error);
        });
}

checkPendingCalls();

setInterval(checkPendingCalls, 5000);

</script>

</body>
</html>