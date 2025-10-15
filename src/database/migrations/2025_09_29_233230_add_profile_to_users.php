<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        schema::table('users' , function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('password');  // プロフィール画像
            $table->string('zipcode')->nullable()->after('avatar');   // 郵便番号
            $table->string('address')->nullable()->after('zipcode');  // 住所
            $table->string('building')->nullable()->after('address'); // 建物名
        });
    }

    public function down(): void
    {
        schema::table('users' , function (Blueprint $table){
            $table->dropColumn(['avatar', 'zipcode', 'address', 'building']);
        });
    }
};