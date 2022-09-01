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
            $table->increments('id');
            $table->string('StudentCd');
            $table->date('HasseiDate');
            $table->string('ZiyuuCd');
            $table->string('ZiyuuHosoku');
            $table->string('TourokuSupporterCd');
            $table->timestamp('UpdateTimeStamp');
            $table->datetime('UpdateDatetime');
            $table->string('UpdateGamen');
            $table->string('UpdateSystem');

            $table->timestamps();
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
