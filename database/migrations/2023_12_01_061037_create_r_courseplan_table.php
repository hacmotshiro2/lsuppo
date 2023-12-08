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
        Schema::create('r_courseplan', function (Blueprint $table) {

            $table->collation = 'utf8mb4_general_ci';

            $table->bigIncrements('id')->unsigned();
            $table->string('StudentCd',8);
            $table->date('ApplicationDate');
            $table->string('CourseCd',3);
            $table->string('PlanCd',3);

            $table->string('UpdateGamen',128);
            $table->string('UpdateSystem',128);

            $table->timestamps();
            $table->softDeletes();

            //外部キーの設定
            $table->foreign('StudentCd')->references('StudentCd')->on('m_student')->onDeletes('no action');
            //制約不要と判断
            // $table->foreign('CourseCd')->references('Code')->on('m_koumoku')->where('Shubetu',110)->onDeletes('no action');
            // $table->foreign('PlanCd')->references('Code')->on('m_koumoku')->where('Shubetu',120)->onDeletes('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('r_courseplan');
    }
};
