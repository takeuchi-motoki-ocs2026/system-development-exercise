<?php
//テーブルテーブル
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
        Schema::create('table', function (Blueprint $table) {
            $table->id('table_id'); // 主キー（自動採番）
            $table->string('store_id', 2); // 店舗ID（外部キー）
            $table->integer('table_number'); // テーブル番号
            $table->string('seat_status', 20)->default('available'); // 空席状況
            $table->integer('max_people'); // 最大人数
            $table->timestamps();

            // 外部キー制約
            $table->foreign('store_id')//外部キー名　　　　　　
                  ->references('store_id')//参照先の主キー
                  ->on('store');//参照先のテーブル名
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table');
    }
};
