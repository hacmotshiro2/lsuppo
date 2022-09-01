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
        Schema::create('r_lc_lcoinmeisai', function (Blueprint $table) {

            $table->collation = 'utf8mb4_general_ci';

            $table->bigIncrements('id')->unsigned();
            $table->string('StudentCd',8);
            $table->date('HasseiDate');
            $table->string('ZiyuuCd',3);
            $table->string('ZiyuuHosoku',200)->nullable();
            $table->integer('Amount');
            $table->string('TourokuSupporterCd',8);
            $table->string('UpdateGamen',128);
            $table->string('UpdateSystem',128);

            $table->timestamps();
            $table->softDeletes();


            //外部キーの設定
            $table->foreign('StudentCd')->references('StudentCd')->on('m_student')->onDeletes('no action');
            $table->foreign('ZiyuuCd')->references('ZiyuuCd')->on('m_lc_ziyuu')->onDeletes('no action');
            $table->foreign('TourokuSupporterCd')->references('SupporterCd')->on('m_supporter')->onDeletes('no action');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('r_lc_lcoinmeisai');
    }
};
