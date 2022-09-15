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
        Schema::create('r_convtxtmeisai', function (Blueprint $table) {
            $table->collation = 'utf8mb4_general_ci';

            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('Header_id')->unsigned();
            $table->integer('LineCount')->unsigned();
            $table->string('OriginalSpeaker',30);
            $table->time('OriginalTime');
            $table->string('OriginalConversation',400);
            $table->string('SpeakerCd',8)->nullable();
            $table->string('Speaker',30)->nullable();
            $table->string('Conversation',400);
            $table->string('Comment',200)->nullable();
            $table->string('UpdateGamen',128);
            $table->string('UpdateSystem',128);


            $table->timestamps();
            $table->softDeletes();

            //外部キーの設定
            $table->foreign('Header_id')->references('id')->on('r_convtxthead')->onDeletes('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('r_convtxtmeisai');
    }
};
