<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up(): void
{
    Schema::create('categories', function (Blueprint $table) {
        $table->id(); // 主キー
        $table->string('name'); // カテゴリ名
        $table->unsignedBigInteger('parent_id')->nullable(); // 親カテゴリID（NULL許可）
        $table->timestamps(); // created_at, updated_at

        // 外部キー制約（親カテゴリを参照する自己リレーション）
        $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
