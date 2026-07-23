<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>入店案内</title>

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

/* ===== 選択ボタン ===== */

.select-btn {
    background: #222;
    color: white;
    border: none;
    padding: 5px 15px;
    cursor: pointer;
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
    inset: 0;
    background: rgba(0,0,0,0.2);
    justify-content: center;
    align-items: center;
    z-index: 999;
}

.modal-content {
    width: 320px;
    background: #efefef;
    border: 1px solid #666;
    padding: 25px;
    text-align: center;
}

.course-buttons {
    display: flex;
    justify-content: space-between;
    margin: 30px 0;
}

.drink-btn {
    width: 130px;
    height: 40px;
    background: #ff4d4d;
    color: white;
    border: 1px solid #666;
    font-size: 18px;
    cursor: pointer;
}

.normal-btn {
    width: 130px;
    height: 40px;
    background: #ff8533;
    color: white;
    border: 1px solid #666;
    font-size: 18px;
    cursor: pointer;
}

.modal-back-btn {
    width: 90px;
    height: 35px;
    background: #999;
    color: white;
    border: 1px solid #666;
    cursor: pointer;
}
</style>
</head>

<body>

<div class="header"></div>

<div class="container">

    <h2>入店案内</h2>

    <table>

        <thead>
            <tr>
                <th>席番号</th>
                <th>定員</th>
                <th>コース選択</th>
            </tr>
        </thead>

        <tbody>

        @foreach($tables as $table)

        @if($table->seat_status === 'available')

        <tr>

            <td>{{ $table->table_number }}</td>

            <td>{{ $table->max_people }}</td>

            <td>

                <button
                    class="select-btn"
                    onclick="openCourseModal(
                        {{ $table->table_id }},
                        {{ $table->table_number }},
                        {{ $table->max_people }}
                    )">

                    選択

                </button>

            </td>

        </tr>

        @endif

        @endforeach

        </tbody>

    </table>

    <button
        class="back-btn"
        onclick="location.href='/project/home'">
        戻る
    </button>

</div>

<div class="footer">

    <button class="home-icon-btn"
        onclick="location.href='/project/home'">

        ⌂

    </button>

</div>

<!-- コース選択モーダル -->

<div id="courseModal" class="modal">

    <div class="modal-content">

        <h2>コース選択</h2>

        <p id="selectedSeatText"></p>

        <div class="people-area">
            <label for="peopleSelect">利用人数</label>

            <select id="peopleSelect">
                <option value="">人数を選択</option>
            </select>
        </div>

        <div class="course-buttons">
            <button
                class="drink-btn"
                onclick="selectCourse('all_you_can_drink')">
                飲み放題
            </button>

            <button
                class="normal-btn"
                onclick="selectCourse('normal')">
                通常
            </button>
        </div>

        <button
            class="modal-back-btn"
            onclick="closeCourseModal()">
            戻る
        </button>

    </div>

</div>

<script>

let selectedTableId = null;
let selectedSeat = null;
let selectedMaxPeople = null;

/* モーダル表示 */
function openCourseModal(tableId, seatNo, maxPeople)
{
    selectedTableId = tableId;
    selectedSeat = seatNo;
    selectedMaxPeople = maxPeople;

    document.getElementById("selectedSeatText").textContent =
        seatNo + "番席（最大" + maxPeople + "人）";

    const peopleSelect =
        document.getElementById("peopleSelect");

    // 前の席の選択肢を消す
    peopleSelect.innerHTML =
        '<option value="">人数を選択</option>';

    // 最大人数まで選択肢を作る
    for (let i = 1; i <= maxPeople; i++) {

        const option =
            document.createElement("option");

        option.value = i;
        option.textContent = i + "人";

        peopleSelect.appendChild(option);
    }

    document.getElementById("courseModal").style.display = "flex";
}

/* モーダル閉じる */
function closeCourseModal()
{
    document.getElementById("courseModal").style.display = "none";

    document.getElementById("peopleSelect").value = "";

    selectedTableId = null;
    selectedSeat = null;
    selectedMaxPeople = null;
}

/* コース選択 */
function selectCourse(course)
{
    const people =
        document.getElementById("peopleSelect").value;

    if (!people) {
        alert("利用人数を選択してください");
        return;
    }

    fetch("/project/staff/visit", {
        method: "POST",

        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },

        body: JSON.stringify({
            table_id: selectedTableId,
            course: course,
            people_count: Number(people)
        })
    })
    .then(async response => {

        const data = await response.json();

        if (!response.ok) {
            throw new Error(
                data.message || "入店登録に失敗しました"
            );
        }

        return data;
    })
    .then(data => {

        location.href = data.redirect_url;

    })
    .catch(error => {

        console.error(error);
        alert(error.message);

    });
}

window.onload = function(){

    document.querySelectorAll("tbody tr").forEach(row => {

        const seatNo = row.querySelector("td")?.textContent.trim();

        if(!seatNo) return;

        const state = localStorage.getItem("seat" + seatNo);

        const btn = row.querySelector(".select-btn");

        if(!btn) return;

        // ★「空」はそのまま表示
        if(state === "空"){
            btn.textContent = "選択";
            btn.style.background = "#222";
        }

        // ★「使」もそのまま表示（重要）
        if(!state || state === "使"){
            btn.textContent = "選択";
            btn.style.background = "#222";
        }
    });
};

</script>

</body>
</html>