<?php

// 利用テーブル

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
            // 主キー
            $table->id('used_table_id');

            // 外部キー
            $table->unsignedBigInteger('table_id');
            $table->unsignedBigInteger('customer_id');

            // 今回の利用人数
            $table->unsignedInteger('people_count');

            // 今回選択したコース
            $table->enum('course', [
                'normal',
                'all_you_can_drink',
            ])->default('normal');

            // 利用開始・終了日時
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();

            $table->timestamps();

            // tableテーブルと紐付け
            $table->foreign('table_id')
                ->references('table_id')
                ->on('table')
                ->cascadeOnDelete();

            // customerテーブルと紐付け
            $table->foreign('customer_id')
                ->references('customer_id')
                ->on('customer')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('used_table');
    }
};