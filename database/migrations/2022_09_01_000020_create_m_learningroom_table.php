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
        Schema::create('m_learningroom', function (Blueprint $table) {
            $table->collation = 'utf8mb4_general_ci';
          
            $table->string('LearningRoomCd',6);
            $table->string('LearningRoomName',40);
            $table->string('UpdateGamen',128);
            $table->string('UpdateSystem',128);

            $table->timestamps();
            $table->softDeletes();

            //主キーの設定
            $table->primary('LearningRoomCd');
            
            //外部キーの設定
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_learningroom');
    }
};
