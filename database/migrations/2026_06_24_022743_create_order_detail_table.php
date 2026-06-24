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
        Schema::create('order_detail', function (Blueprint $table) {
            $table->id('order_detail_id'); // 主キー（自動採番）

            $table->unsignedBigInteger('order_id'); // 注文ID（外部キー）
            $table->unsignedBigInteger('product_id'); // 商品ID（外部キー）

            $table->integer('quantity'); // 数量
            $table->integer('served_quantity'); // 配膳個数

            $table->timestamps(); // 作成日時・更新日時

            // 外部キー制約（注文ID）
            $table->foreign('order_id') // 外部キー名（order_detail.order_id）
                ->references('order_id') // 参照先の主キー（order.order_id）
                ->on('order'); // 参照先のテーブル名

            // 外部キー制約（商品ID）
            $table->foreign('product_id') // 外部キー名（order_detail.product_id）
                ->references('product_id') // 参照先の主キー（product.product_id）
                ->on('product'); // 参照先のテーブル名
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void//ロールバック用
    {
        Schema::dropIfExists('order_detail');
    }
};
