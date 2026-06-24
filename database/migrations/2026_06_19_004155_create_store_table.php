<?php
//店舗テーブル
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {   //店舗テーブル
        Schema::create('store', function (Blueprint $table) {
            $table->string('store_id', 2)->primary(); // AA〜ZZ の2文字
            $table->string('store_number', 20)->unique(); // 店舗番号
            $table->timestamps(); // 作成日・更新日
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store');
    }
};
