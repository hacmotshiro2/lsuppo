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
        Schema::table('r_fe_feedbackmeisai', function (Blueprint $table) {
            //
            // $table->string('ApprovalToken',40)->collation('utf8mb4_general_ci')->default(uniqid('',true));
            $table->string('ApprovalToken',40)->collation('utf8mb4_general_ci');

            $table->unique('ApprovalToken');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('r_fe_feedbackmeisai', function (Blueprint $table) {
            //
            $table->dropColumn('ApprovalToken');

        });
    }
};
