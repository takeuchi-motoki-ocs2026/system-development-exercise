<?php
//利用テーブル
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
        Schema::create('used_table', function (Blueprint $table) {
            $table->id('used_table_id'); // 主キー（自動採番）

            $table->unsignedBigInteger('table_id'); // テーブルID（外部キー）
            $table->unsignedBigInteger('customer_id'); // 顧客ID（外部キー）

            $table->dateTime('start_time'); // 利用開始日時
            $table->dateTime('end_time')->nullable(); // 利用終了日時（まだ退店していない場合はNULL）

            $table->timestamps();

            // 外部キー制約
            $table->foreign('table_id')//外部キー名　
                ->references('table_id')//参照先の主キー
                ->on('table');//参照先のテーブル名

            $table->foreign('customer_id')//外部キー名　
                ->references('customer_id')//参照先の主キー
                ->on('customer');//参照先のテーブル名
        });
    }
};
