<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>新規注文</title>

<style>

body{
    margin:0;
    font-family:sans-serif;
    background-color:#e6b98a;

    display:flex;
    flex-direction:column;
    min-height:100vh;
}

/* ヘッダーとフッター */
.header,
.footer{
    height:60px;
    background-color:#e0663f;

    flex-shrink:0;
}

/* メイン */
.container{
    flex:1;
    padding:10px;
}

/* タイトル */
h2{
    margin:15px 0;
}

/* 中央配置部分 */
.content{

    margin-top:80px;

    display:flex;
    flex-direction:column;

    align-items:center;
}

/* 席選択 */
.select-area{

    display:flex;

    align-items:center;

    gap:10px;
}

/* ドロップダウン */
.seat-select{

    width:100px;

    height:35px;

    font-size:18px;

    border:2px solid #3aa0ff;

    background:white;
}

/* ボタンエリア */
.btn-area{

    margin-top:20px;

    display:flex;

    gap:15px;
}

/* 戻るボタン */
.back-btn{

    width:80px;

    padding:12px;

    background-color:#35c3e6;

    color:white;

    border:1px solid #666;

    font-size:18px;
}

/* 履歴ボタン（メニュー追加の追加ボタンと同じ） */
.history-btn{

    width:80px;

    padding:12px;

    background-color:red;

    color:white;

    border:none;

    font-size:18px;

    cursor:pointer;
}

/* 無効状態（メニュー追加と同じ） */
.history-btn:disabled{

    background-color:#aaa;

    cursor:not-allowed;

    opacity:0.6;
}

</style>
</head>

<body>

<div class="header"></div>

<div class="container">

    <h2>新規注文</h2>

    <div class="content">

        <div class="select-area">

            <select class="seat-select" id="seatSelect">

                <option value=""></option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>

            </select>

            <span>席</span>

        </div>

        <div class="btn-area">

            <button class="back-btn"
                onclick="location.href='{{ route('projecthome') }}'">

                戻る

            </button>

            <button class="history-btn"
                    id="historyBtn"
                    disabled>

                注文

            </button>

        </div>

    </div>

</div>

<div class="footer"></div>

<script>

/* 席選択で有効化 */
document.getElementById("seatSelect")
.addEventListener("change", function(){

    const btn = document.getElementById("historyBtn");

    if(this.value !== ""){

        btn.disabled = false;

    }else{

        btn.disabled = true;
    }

});

document.getElementById("historyBtn")
.addEventListener("click", function(){

    const seat = document.getElementById("seatSelect").value;

    if(seat !== ""){
        window.location.href = `/project/staff/order/home?seat=${seat}`;
    }
});

</script>

</body>
</html>