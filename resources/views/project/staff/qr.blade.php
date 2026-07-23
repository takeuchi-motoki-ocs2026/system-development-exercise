<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>QRコード</title>

<style>

body{
    margin:0;
    font-family:sans-serif;
    background:#e6b98a;
    display:flex;
    flex-direction:column;
    min-height:100vh;
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

.container{
    flex:1;
    padding:20px;
}

h2{
    margin:15px 0;
}

.qr-box{
    margin:50px auto;
    background:white;
    padding:15px;
    border:1px solid #666;

    display:flex;
    justify-content:center;
    align-items:center;
}

.seat-label{
    display: flex;
    justify-content: center;
    align-items: center;

    margin-top: 40px;

    font-size: 40px;
    font-weight: bold;

    text-align: center;
}

.back-btn{
    margin-top:60px;
    width:120px;
    padding:12px;
    background:#35c3e6;
    color:white;
    border:1px solid #666;
    font-size:20px;
}

</style>
</head>

<body>

<div class="header"></div>

<div class="container">

    <h2>空席管理</h2>

    <div class="qr-box">

        @if($token)

            @php
                $url = url('/project/entry')
                    . '?token=' . urlencode($token);
            @endphp

            {!! QrCode::size(200)->generate($url) !!}

        @else

            <p>QRコードを発行できませんでした。</p>

        @endif

    </div>

    <div class="seat-label">
        {{ $seat }}席
    </div>

    <button
        class="back-btn"
        onclick="location.href='{{ route('project.staff.vacancy') }}'">
        戻る
    </button>

</div>

<div class="footer">

    <button class="home-icon-btn"
        onclick="location.href='{{ route('projecthome') }}'">

        ⌂

    </button>

</div>

</body>
</html>