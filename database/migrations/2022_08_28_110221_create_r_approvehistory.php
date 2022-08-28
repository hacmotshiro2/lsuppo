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
        Schema::create('r_approvehistory', function (Blueprint $table) {
            $table->collation = 'utf8mb4_general_ci';

            $table->bigincrements('id');
            $table->string('TargetToken',40)->collation('utf8mb4_general_ci');
            $table->datetime('HasseiDate');
            $table->string('ShouninStatus',3);
            $table->string('Comment',800)->nullable();
            $table->string('TourokuSupporterCd',8);
            $table->string('UpdateGamen');
            $table->string('UpdateSystem');

            $table->timestamps();
            $table->softDeletes();

            // $table->primary('id');//書かなくていい
            
            // $table->foreign('TargetToken')->references('ApprovalToken')->on('r_fe_feedbackmeisai')->onDeletes('cascade');//不要と判断
            $table->foreign('TourokuSupporterCd')->references('SupporterCd')->on('m_supporter')->onDeletes('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('r_approvehistory');
    }
};
