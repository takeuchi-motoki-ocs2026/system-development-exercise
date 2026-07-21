<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calls', function (Blueprint $table) {
            $table->id();

            // 呼び出した席
            $table->unsignedBigInteger('table_id');

            // 呼び出し種類
            $table->string('request_type')
                  ->default('call_staff');

            // 呼び出し状態
            $table->enum('status', [
                'pending',
                'processing',
                'completed'
            ])->default('pending');

            $table->timestamps();

            // tables.table_id と紐付け
            $table->foreign('table_id')
                  ->references('table_id')
                  ->on('table')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calls');
    }
};