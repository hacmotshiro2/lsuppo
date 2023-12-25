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
        Schema::create('m_monthlyfee', function (Blueprint $table) {

            $table->collation = 'utf8mb4_general_ci';

            $table->string('CPCd',3);
            $table->string('CourseCd',3);
            $table->string('PlanCd',3);
            $table->integer('Fee');
            $table->string('Description',255)->nullable();

            $table->timestamps();
            $table->softDeletes();

            //外部キーの設定
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
        Schema::dropIfExists('m_monthlyfee');
    }
};
