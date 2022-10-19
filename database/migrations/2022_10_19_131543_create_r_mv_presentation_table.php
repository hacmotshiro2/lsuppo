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
        Schema::create('r_mv_presentation', function (Blueprint $table) {
            $table->collation = 'utf8mb4_general_ci';

            $table->id()->unsigned();
            $table->string('StudentCd',8);
            $table->date('ShootingDate');
            $table->string('Title',40);
            $table->string('Description',200)->nullable();
            $table->string('YouTubeId',128);
            $table->string('UpdateGamen',128);
            $table->string('UpdateSystem',128);

            $table->timestamps();

             //外部キーの設定
             $table->foreign('StudentCd')->references('StudentCd')->on('m_student')->onDeletes('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('r_mv_presentation');
    }
};
