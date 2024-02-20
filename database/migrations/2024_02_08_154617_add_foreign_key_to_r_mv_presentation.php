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
        Schema::table('r_mv_presentation', function (Blueprint $table) {
            // 外部キー制約を追加
            $table->foreign('StudentCd')->references('StudentCd')->on('m_student');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('r_mv_presentation', function (Blueprint $table) {
            // 外部キー制約を削除
            $table->dropForeign(['StudentCd']);
            // $table->dropColumn('StudentCd');
        });
    }

};