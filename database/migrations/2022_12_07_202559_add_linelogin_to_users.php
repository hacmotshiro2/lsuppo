<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //LINE Login関連
            //userTypeの定義はコンスト
            $table->tinyInteger('ll_enabled')->nullable()->default(0);
            $table->string('line_user_id',64)->nullable();
            $table->tinyInteger('lnots_enabled')->nullable()->default(0);
            $table->tinyInteger('notification_type')->nullable()->default(0);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('ll_enabled');
            $table->dropColumn('line_user_id');
            $table->dropColumn('lnots_enabled');
            $table->dropColumn('notification_type');
        });
    }
};
