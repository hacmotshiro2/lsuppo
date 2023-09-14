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
        Schema::create('r_absence', function (Blueprint $table) {
            $table->collation = 'utf8mb4_general_ci';

            $table->bigIncrements('id')->unsigned();
            $table->string('StudentCd',8);
            $table->date('AbsentDate');
            $table->dateTime('NotifiedDatetime');
            $table->date('ToYoteiDate')->nullable();
            $table->date('ToActualDate')->nullable();
            $table->date('ExpirationDate')->nullable();
            $table->string('LCZiyuuCd',3);
            $table->string('LCZiyuuHosoku',200)->nullable();
            $table->integer('LCYoteiAmountImm')->unsigned();
            $table->integer('LCYoteiAmountExp')->unsigned();
            $table->dateTime('LCSwapedDatetime')->nullable();
            $table->bigInteger('LCMeisaiId')->unsigned()->nullable();
            $table->string('TourokuSupporterCd',8);

            $table->string('UpdateGamen',128);
            $table->string('UpdateSystem',128);

            $table->timestamps();
            $table->softDeletes();

            //外部キーの設定
            $table->foreign('StudentCd')->references('StudentCd')->on('m_student')->onDeletes('no action');
            $table->foreign('TourokuSupporterCd')->references('SupporterCd')->on('m_supporter')->onDeletes('no action');
            $table->foreign('LCMeisaiId')->references('id')->on('r_lc_lcoinmeisai')->onDeletes('no action');
            $table->foreign('LCZiyuuCd')->references('ZiyuuCd')->on('m_lc_ziyuu')->onDeletes('no action');


            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('r_absence');
    }
};
