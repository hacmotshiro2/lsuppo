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
        Schema::create('m_hogosha', function (Blueprint $table) {
            $table->collation = 'utf8mb4_general_ci';

            $table->string('HogoshaCd',8);
            $table->string('Sei',12);
            $table->string('Mei',12);
            $table->string('Hurigana',24);
            $table->date('RiyouKaisiDate',128)->nullable();
            $table->date('RiyouShuuryouDate',128)->nullable();
            $table->string('LearningRoomCd',6);
            $table->boolean('IsLocked')->default(false);
            $table->boolean('IsNeedPWChange')->default(false);
            $table->string('UpdateGamen',128);
            $table->string('UpdateSystem',128);

            $table->timestamps();
            $table->softDeletes();

            //主キーの設定
            $table->primary('HogoshaCd');
            
            //外部キーの設定
            $table->foreign('LearningRoomCd')->references('LearningRoomCd')->on('m_learningroom')->onDeletes('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_hogosha');
    }
};
