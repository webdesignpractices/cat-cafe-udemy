<?php

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
        Schema::table('blogs', function (Blueprint $table) {
            //$table->foreignID('category_id')->nullable()->after('id')->constrained();
            //$table->foreignID('category_id')->default(4)->after('id')->constrained();//categoriesテーブルの'4'=>'その他'の4
            $table->foreignId('category_id')->after('id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
        });
    }
};
