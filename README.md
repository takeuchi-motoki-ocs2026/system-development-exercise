# システム開発演習 モバイルオーダーシステム

## 動作環境

- Windows 10 / 11
- PHP 8.2 以上
- Composer 2.x
- MySQL 8.0
- Laravel 10.x

---

# 初回セットアップ

## 1. 必要ソフトのインストール

### PHP

以下を参考にインストールしてください。

https://qiita.com/coconuts-harm/items/8803f6d4f99e7c734582

---

### Composer

以下を参考にインストールしてください。

https://qiita.com/taiyang-ks/items/0da7effa807111b92c25

---

### MySQL

以下を参考にインストールしてください。

https://qiita.com/KOJI-YAMAMOTO/items/02af20e7b5cd27932a27

---

## 2. リポジトリを取得

```bash
git clone {https://github.com/syun17/system-development-exercise.git}
cd {system-development-exercise}
```

---

## 3. 必要パッケージをインストール

```bash
composer install
```

---

## 4. 環境変数ファイルを作成

```bash
copy .env.example .env
```

---

## 5. データベースを作成

MySQLにログインします。

```bash
mysql -u root -p
```

データベースを作成します。

```sql
CREATE DATABASE mobile_order;
```

---

## 6. .env を設定

`.env` ファイルを開き、以下を設定してください。

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mobile_order
DB_USERNAME=root
DB_PASSWORD=
```

※ `DB_PASSWORD` は各自の環境に合わせて変更してください。

---

## 7. MySQLを起動

```bash
mysqld --defaults-file="C:\Users\{学籍番号}\mysql\my.ini"
```

---

## 8. アプリケーションキーを生成

```bash
php artisan key:generate
```

---

## 9. マイグレーションを実行

```bash
php artisan migrate
```

---

## 10. サーバーを起動

```bash
php artisan serve
```

起動後、以下へアクセスしてください。

http://127.0.0.1:8000

---

# 2回目以降の起動

## 1. MySQLを起動

```bash
mysqld --defaults-file="C:\Users\{学籍番号}\mysql\my.ini"
```

---

## 2. Laravelサーバーを起動

```bash
php artisan serve
```

プロトタイプ用
```bash
php artisan serve --host=0.0.0.0 --port=80
```

---

# よくあるエラー

## MySQLのPATH設定

### 設定方法

1. スタートメニューで「環境変数」と検索
2. 「システム環境変数を編集」を開く
3. 「環境変数」を押す
4. 「Path」を選択して編集

以下を追加してください。

```txt
C:\Users\{学籍番号}\mysql\bin
```

設定後、新しいコマンドプロンプトで以下を実行します。

```bash
mysql --version
```

バージョンが表示されればOKです。

---

## php.ini の設定

`php.ini` を開き、以下を探してください。

```ini
;extension=fileinfo
;extension=pdo_mysql
;extension=mysqli
```

先頭の `;` を削除してください。

```ini
extension=fileinfo
extension=pdo_mysql
extension=mysqli
```

保存後、コマンドプロンプトを再起動してください。

---

## No application encryption key has been specified.

以下を実行してください。

```bash
php artisan key:generate
```

---

## Class "PDO" not found

`php.ini` の `pdo_mysql` が有効になっているか確認してください。

```ini
extension=pdo_mysql
```

---

## ポートが使用中の場合

以下のようにポート番号を変更してください。

```bash
php artisan serve --port=8080
```

アクセス先：

http://127.0.0.1:8080

---

## MySQLに接続できない場合

以下で接続確認してください。

```bash
mysql -u root -p
```

接続できない場合は、

- MySQLが起動しているか
- `.env` のユーザー名・パスワード
- ポート番号

を確認してください。

---

# 開発用コマンド

## キャッシュ削除

```bash
php artisan config:clear
php artisan cache:clear
```

---

## テーブルを初期化して再作成

```bash
php artisan migrate:fresh
```

---

# 注意事項

- `.env` ファイルはGitにアップロードしないでください
- `vendor` フォルダは `composer install` で再生成されます
- エラーが出た場合は、エラーメッセージをよく読んでください

# フォルダ構成

## MVCアーキテクチャ

- Model データ関連:データベース
- View 表示関連:画面 (プロトタイプの実装はこれ)
- Controller 仲介処理:

### Model
app/Modelsディレクトリ

### View
resources/viewsディレクトリ

### Controller
routes/web.phpフォルダでルーティング
App\Http\Controllersフォルダで処理追加

# プロトタイプの作成方法
1. 作成済みのhtmlファイルを用意
2. resources/views/projectフォルダの中に貼り付け
3. 拡張子を`.html`から`.blade.php`に変更
4. routes/web.phpファイルに以下を追加
```
Route::view('/project/{ファイル名}', 'project.{ファイル名}')->name('{ファイル名}');
```
5. 起動後http://127.0.0.1:8000/project/{ファイル名}を確認
6. ファイル内のURLを調整

## CSS,Javascriptの適用方法
CSSとJavascriptは `public` フォルダに置いて配信します。
1. CSSファイルとJavascriptファイルを用意する
2. CSSファイルは `public/css` フォルダに、Javascriptファイルは `public/js` フォルダに入れる
3. `resources/views/project` フォルダのBladeファイルで以下のように読み込む
```
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script src="{{ asset('js/app.js') }}" defer></script>
```
4. ファイル内のURLや画像パスを必要に応じて調整する
5. 起動後 http://127.0.0.1:8000/project/{ファイル名} を確認する