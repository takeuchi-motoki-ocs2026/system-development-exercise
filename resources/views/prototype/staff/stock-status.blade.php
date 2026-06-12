<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>在庫状況</title>

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

/* ===== プルダウン ===== */

.stock-select {

    width: 100%;

    border: none;

    background-color: white;

    font-size: 16px;

    text-align: center;
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

    <h2>在庫状況</h2>

    <table>

        <thead>
            <tr>
                <th>商品名</th>
                <th>在庫</th>
            </tr>
        </thead>

        <tbody>

            <tr>

                <td>ねぎま(塩)</td>

                <td>

                    <select class="stock-select">

                        <option>有</option>

                        <option>無</option>

                    </select>

                </td>

            </tr>

            <tr>

                <td>生ビール</td>

                <td>

                    <select class="stock-select">

                        <option>有</option>

                        <option>無</option>

                    </select>

                </td>

            </tr>

            <tr>

                <td>コークハイ</td>

                <td>

                    <select class="stock-select">

                        <option>有</option>

                        <option>無</option>

                    </select>

                </td>

            </tr>

            <!-- 空行 -->

            <tr>
                <td>&nbsp;</td>
                <td></td>
            </tr>

            <tr>
                <td>&nbsp;</td>
                <td></td>
            </tr>

            <tr>
                <td>&nbsp;</td>
                <td></td>
            </tr>

        </tbody>

    </table>

    <button class="back-btn"
        onclick="location.href='/prototype/menu-management'">

        戻る

    </button>

</div>

<div class="footer">

    <button class="home-icon-btn"
        onclick="location.href='/prototype/home'">

        ⌂

    </button>

</div>

</body>
</html>