<?php

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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // QRで入店した顧客
            $table->unsignedBigInteger('customer_id');

            // 注文したテーブル
            $table->unsignedBigInteger('table_id');

            // 商品情報
            $table->string('name');
            $table->integer('price');
            $table->integer('quantity');
            $table->string('taste');

            // 配膳済み数量
            $table->integer('served_quantity')
                  ->default(0);

            // 表示用の席番号
            $table->integer('seat');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};