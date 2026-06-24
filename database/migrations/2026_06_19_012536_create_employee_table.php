<?php
//店員テーブル
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {   //id➡主キー//
        Schema::create('employee', function (Blueprint $table) {
            $table->id('employee_id'); // 自動採番の主キー
            $table->string('store_id', 2); // 店舗ID（AA〜ZZ）
            $table->string('password'); // パスワード
            $table->string('user_role', 20); // ユーザー権限
            $table->timestamps();

            // 外部キー制約//外部キー名　　　//参照先の主キー　　　//参照先のテーブル名　　　　　　　　　　
            $table->foreign('store_id')->references('store_id')->on('store');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee');
    }
};
