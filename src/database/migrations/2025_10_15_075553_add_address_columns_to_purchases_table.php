<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->string('zipcode')->nullable()->after('item_id');
            $table->string('address')->nullable()->after('zipcode');
            $table->string('building')->nullable()->after('address');
        });
    }

    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn(['zipcode', 'address', 'building']);
        });
    }
};
