<?php
//顧客テーブル
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
        Schema::create('customer', function (Blueprint $table) {
            $table->id('customer_id'); // 主キー（自動採番）

            $table->dateTime('payment_time')->nullable(); // 支払日時（未会計ならNULL）
            $table->string('billStatus', 20); // 会計ステータス（例：unpaid / paid）
            $table->string('qr_code', 255); // QRコード（文字列で保持）

            // Laravel の migration で “自動で2つの日時カラムを作る” 特別な命令。
            //created_at（レコードが作られた日時）
            //updated_at（レコードが更新された日時）
            $table->timestamps();
            
        });
    }
};
