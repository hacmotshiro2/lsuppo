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
        if(Schema::hasTable('r_approvehistory')){
            return;
        }
        Schema::create('r_approvehistory', function (Blueprint $table) {
            $table->collation = 'utf8mb4_general_ci';

            $table->bigincrements('id');
            $table->string('TargetToken',100)->collation('utf8mb4_general_ci');
            $table->datetime('HasseiDate');
            $table->string('ShouninStatus',3);
            $table->string('Comment',800)->nullable();
            $table->string('TourokuSupporterCd',8);
            $table->string('UpdateGamen',128);
            $table->string('UpdateSystem',128);

            $table->timestamps();
            $table->softDeletes();

            
            // $table->foreign('TargetToken')->references('ApprovalToken')->on('r_fe_feedbackmeisai')->onDeletes('no action');//不要と判断
            $table->foreign('TourokuSupporterCd')->references('SupporterCd')->on('m_supporter')->onDeletes('no action');

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
