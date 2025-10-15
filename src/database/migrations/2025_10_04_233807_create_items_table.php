<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 商品名
            $table->integer('price'); // 価格
            $table->string('brand')->nullable(); // ブランド名（空OK）
            $table->text('description')->nullable(); // 商品説明
            $table->string('image'); // 画像URL
            $table->string('condition')->nullable(); // 状態（良好など）
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // 出品者
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
