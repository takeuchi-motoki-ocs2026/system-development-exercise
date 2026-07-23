<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ホーム</title>

<style>
body {
    margin: 0;
    font-family: sans-serif;
    background-color: #e6b98a;

    /* --- フッターを下に押し出すための追加 --- */
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* ヘッダーとフッター */
.header, .footer {
    height: 60px;
    background-color: #e0663f;

    /* 縮まないように固定 */
    flex-shrink: 0;
}

/* メインコンテンツ */
.container {
    padding: 20px;

    /* 余ったスペースをすべて埋めて、フッターを下に押し出す */
    flex: 1;
}

/* タイトル */
h2 {
    margin-bottom: 20px;
}

/* メニューボタン */
.menu-btn {
    display: block;
    width: 100%;

    /* paddingとborderを横幅(width:100%)に含める設定 */
    box-sizing: border-box;

    padding: 20px;
    margin-bottom: 20px;
    background-color: #d8cc8c;
    border: 1px solid #888;
    text-align: center;
    font-size: 18px;
}

/* ログアウトボタン */
.logout {
    background-color: red;
    color: white;
}

.seat-menu-btn{
    position: relative;
    text-decoration: none;
    color: black;
}

.home-call-dot{
    position: absolute;

    top: 8px;
    right: 8px;

    width: 14px;
    height: 14px;

    background: red;
    border-radius: 50%;
}

</style>
</head>

<body>

<div class="header"></div>

<div class="container">
    <h2>ホーム</h2>

    <div class="menu-btn" onclick="location.href='{{ route('projectorder-menu') }}'">
        注文状況
    </div>

    <a href="/project/seat-management" class="menu-btn seat-menu-btn">

        座席管理

        @if($hasPendingCall)
            <span class="home-call-dot"></span>
        @endif

    </a>

    <div class="menu-btn" onclick="location.href='{{ route('project.staff.vacancy') }}'">
        入店案内
    </div>

    <div class="menu-btn" onclick="location.href='{{ route('project.staff.order') }}'">
        新規注文
    </div>

    <div class="menu-btn" onclick="location.href='{{ route('projectmenu-management') }}'">
        メニュー管理
    </div>

    <div class="menu-btn logout" onclick="location.href='{{ route('projectlogin') }}'">
        ログアウト
    </div>
</div>

<div class="footer"></div>

<script>
function checkPendingCall() {
    fetch("{{ route('project.call.pending-check') }}")
        .then(response => {
            if (!response.ok) {
                throw new Error('通知の取得に失敗しました');
            }

            return response.json();
        })
        .then(data => {
            const button = document.querySelector('.seat-menu-btn');
            let dot = button.querySelector('.home-call-dot');

            if (data.hasPendingCall) {

                if (!dot) {
                    dot = document.createElement('span');
                    dot.classList.add('home-call-dot');
                    button.appendChild(dot);
                }

            } else {

                if (dot) {
                    dot.remove();
                }

            }
        })
        .catch(error => {
            console.error(error);
        });
}

checkPendingCall();

setInterval(checkPendingCall, 5000);
</script>

</body>
</html>