# システム開発演習 モバイルオーダーシステム

## 動作環境

- Windows 10 / 11
- PHP 8.2以上
- Composer 2.x
- MySQL 8.0
- Laravel 10.x

---

# 初回セットアップ

## 1. 必要ソフトをインストール

**PHP**  
https://qiita.com/coconuts-harm/items/8803f6d4f99e7c734582

**Composer**  
https://qiita.com/taiyang-ks/items/0da7effa807111b92c25

**MySQL**  
https://qiita.com/KOJI-YAMAMOTO/items/02af20e7b5cd27932a27

## 2. リポジトリを取得

```bash
git clone https://github.com/syun17/system-development-exercise.git
cd system-development-exercise
```

## 3. 必要パッケージをインストール

```bash
composer install
```

## 4. QRコードライブラリをインストール

```bash
composer require simplesoftwareio/simple-qrcode
php artisan optimize:clear
```

## 5. 環境変数ファイルを作成

```bash
copy .env.example .env
```

## 6. `.env` を設定

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mobile_order
DB_USERNAME=root
DB_PASSWORD=
```

※ `DB_PASSWORD` は各自の環境に合わせて変更してください。

## 7. MySQLを起動

```bash
mysqld --defaults-file="C:\Users\{学籍番号}\mysql\my.ini"
```

## 8. データベースを作成

MySQLへログイン

```bash
mysql -u root -p
```

データベース作成

```sql
CREATE DATABASE mobile_order;
```

終了

```sql
exit
```

## 9. アプリケーションキーを生成

```bash
php artisan key:generate
```

## 10. マイグレーションを実行

```bash
php artisan migrate
```

## 11. 初期データを登録

初回のみ、店舗データと座席データを登録してください。

### 店舗データ
```sql
INSERT INTO store
(store_id, store_number, created_at, updated_at)
VALUES
('店舗ID', '店舗名', NOW(), NOW());
```

### 座席データ

```sql
INSERT INTO `table`
(store_id, table_number, seat_status, max_people, created_at, updated_at)
VALUES
('店舗ID', 座席番号, 'available', 最大人数, NOW(), NOW()),
```

## 12. サーバーを起動

```bash
php artisan serve
```

## 13. スタッフ画面へアクセス

サーバー起動後、ブラウザで以下へアクセスしてください。

スタッフログイン画面

http://127.0.0.1:8000/project/login
(ID、パスワード指定なし)

## 14. 入店案内
入店案内画面からQRコードを発行し、それを読み込むことで顧客側の注文画面に移動する

---

# 2回目以降の起動

## 1. MySQLを起動

```bash
mysqld --defaults-file="C:\Users\{学籍番号}\mysql\my.ini"
```

## 2. Laravelサーバーを起動

通常

```bash
php artisan serve
```

## 3. スタッフ画面へアクセス

ブラウザで以下へアクセスしてください。

http://127.0.0.1:8000/project/login

# よくあるエラー

## MySQLのPATH設定

環境変数 `Path` に追加

```txt
C:\Users\{学籍番号}\mysql\bin
```

確認

```bash
mysql --version
```

## php.ini の設定

以下を有効化してください。

```ini
extension=fileinfo
extension=pdo_mysql
extension=mysqli
```

## No application encryption key has been specified.

```bash
php artisan key:generate
```

## Class "PDO" not found

```ini
extension=pdo_mysql
```

を有効にしてください。

## Class "QrCode" not found

```bash
composer require simplesoftwareio/simple-qrcode
php artisan optimize:clear
```

## ポートが使用中

```bash
php artisan serve --port=8080
```

アクセス先

```
http://127.0.0.1:8080
```

## MySQLに接続できない

接続確認

```bash
mysql -u root -p
```

確認項目

- MySQLが起動しているか
- `.env` の設定
- ポート番号

---

# 開発用コマンド

## キャッシュ削除

```bash
php artisan config:clear
php artisan cache:clear
```

## テーブルを初期化して再作成

```bash
php artisan migrate:fresh
```

---

# 注意事項

- `.env` ファイルはGitにアップロードしないでください。
- `vendor` フォルダは `composer install` で再生成されます。
- エラーが出た場合は、エラーメッセージを確認してください。

---

# フォルダ構成

## MVCアーキテクチャ

- Model：データ関連（データベース）
- View：表示関連（画面）
- Controller：処理

### Model

```
app/Models
```

### View

```
resources/views
```

### Controller

```
routes/web.php
app/Http/Controllers
```

---

# プロトタイプの作成方法

1. 作成済みのHTMLファイルを用意する
2. `resources/views/project` フォルダへ配置する
3. 拡張子を `.html` から `.blade.php` に変更する
4. `routes/web.php` に以下を追加する

```php
Route::view('/project/{ファイル名}', 'project.{ファイル名}')->name('{ファイル名}');
```

5. ファイル内のURLを必要に応じて調整する
6. ブラウザで以下へアクセスして確認する

```
http://127.0.0.1:8000/project/{ファイル名}
```

---

# CSS・JavaScriptの適用方法

CSSとJavaScriptは `public` フォルダに配置して配信します。

1. CSSファイルを `public/css` に配置する
2. JavaScriptファイルを `public/js` に配置する
3. Bladeファイルで読み込む

```html
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script src="{{ asset('js/app.js') }}" defer></script>
```

4. 必要に応じてURLや画像パスを調整する
5. ブラウザで以下へアクセスして確認する

```
http://127.0.0.1:8000/project/{ファイル名}
```