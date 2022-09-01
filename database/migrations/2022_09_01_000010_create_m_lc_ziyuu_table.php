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

            $table->collation = 'utf8mb4_general_ci';

            $table->string('ZiyuuCd',3);
            $table->string('Ziyuu',40);
            $table->integer('DefaultAmount');
            $table->string('UpdateGamen',128);
            $table->string('UpdateSystem',128);

            $table->timestamps();

            $table->primary('ZiyuuCd');

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
