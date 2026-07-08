<?php
//注文詳細テーブル
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id('product_id'); // 主キー（自動採番）

            $table->string('product_name', 100); // 商品名
            $table->integer('price'); // 単価
            $table->decimal('tax', 3, 2)->default(0.10); // 税率（10%）
            $table->unsignedBigInteger('category_id'); // カテゴリID（外部キー）
            $table->string('stock_status', 20); // 在庫状態
            $table->string('store_id', 2); // 店舗ID（外部キー）

            $table->timestamps(); // 作成日時・更新日時

            // 外部キー制約（カテゴリID）
            $table->foreign('category_id') // 外部キー名（product.category_id）
                ->references('category_id') // 参照先の主キー（category.category_id）
                ->on('category'); // 参照先のテーブル名

            // 外部キー制約（店舗ID）
            $table->foreign('store_id') // 外部キー名（product.store_id）
                ->references('store_id') // 参照先の主キー（store.store_id）
                ->on('store'); // 参照先のテーブル名
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
