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
        // if (Schema::hasTable('r_fe_feedbackmeisai')) {
        //     // テーブルが存在していればリターン
        //     return;
        // }

        Schema::create('r_fe_feedbackmeisai', function (Blueprint $table) {

            $table->collation = 'utf8mb4_general_ci';

            $table->bigIncrements('FbNo')->unsigned();
            $table->string('StudentCd',8);
            $table->string('FbShurui',3);
            $table->date('TaishoukikanFrom');
            $table->date('TaishoukikanTo');
            $table->string('LearningRoomCd',6);
            $table->string('Title',40);
            $table->string('Detail',800);
            $table->datetime('FirstReadDate')->nullable();
            $table->datetime('LastReadDate')->nullable();
            $table->string('KinyuuSupporterCd',8);
            $table->datetime('KinyuuDate');
            $table->string('ShouninSupporterCd',8)->nullable();
            $table->datetime('ShouninDate')->nullable();
            $table->string('ShouninStatus',3);
            $table->string('ApprovalToken',100)->collation('utf8mb4_general_ci');
            $table->string('UpdateGamen',128);
            $table->string('UpdateSystem',128);


            $table->timestamps();
            $table->softDeletes();

            //外部キーの設定
            $table->foreign('StudentCd')->references('StudentCd')->on('m_student')->onDeletes('no action');
            $table->foreign('LearningRoomCd')->references('LearningRoomCd')->on('m_learningroom')->onDeletes('no action');
            $table->foreign('KinyuuSupporterCd')->references('SupporterCd')->on('m_supporter')->onDeletes('no action');
            $table->foreign('ShouninSupporterCd')->references('SupporterCd')->on('m_supporter')->onDeletes('no action');

            //キー
            // $table->primary('FbNo');これをしなくてもPKになってた
            $table->unique('ApprovalToken');
            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('r_fe_feedbackmeisai');
    }
};
