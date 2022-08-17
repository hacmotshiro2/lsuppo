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
        Schema::table('r_lc_lcoinmeisai', function (Blueprint $table) {
            //
            $table->integer('amount');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('r_lc_lcoinmeisai', function (Blueprint $table) {
            //
            $table->dropColumn('amount');
        });
    }
};
