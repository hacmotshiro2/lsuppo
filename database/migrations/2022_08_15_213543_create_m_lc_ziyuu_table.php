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
        Schema::create('m_lc_ziyuu', function (Blueprint $table) {
            $table->string('ZiyuuCd');
            $table->string('Ziyuu');
            $table->string('Amount');
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
        Schema::dropIfExists('m_lc_ziyuu');
    }
};
