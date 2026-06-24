<?php
//注文テーブル
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
        Schema::create('order', function (Blueprint $table) {
            $table->id('order_id'); // 主キー（自動採番）

            $table->unsignedBigInteger('used_table_id'); // 利用テーブルID（外部キー）
            $table->dateTime('order_time'); // 注文日時

            // Laravel の migration で “自動で2つの日時カラムを作る” 特別な命令。
            //created_at（レコードが作られた日時）
            //updated_at（レコードが更新された日時）
            $table->timestamps();

            // 外部キー制約
            $table->foreign('used_table_id') // 外部キー名（order.used_table_id）
                ->references('used_table_id') // 参照先の主キー（used_table.used_table_id）
                ->on('used_table'); // 参照先のテーブル名
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void//ロールバック用
    {
        Schema::dropIfExists('order');
    }
};
