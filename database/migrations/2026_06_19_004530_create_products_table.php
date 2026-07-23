<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->integer('price');
            $table->string('image')->nullable();

            $table->string('category')->default('food');

            $table->boolean('has_option')
                  ->default(false);

            $table->boolean('is_available')
                  ->default(true);

            $table->unsignedBigInteger('shop_id')
                  ->default(1);

            $table->string('stock_status')
                  ->default('有');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};