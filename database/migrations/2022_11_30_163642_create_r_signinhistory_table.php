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
        Schema::create('r_signinhistory', function (Blueprint $table) {
            $table->collation = 'utf8mb4_general_ci';
            
            $table->bigIncrements('id')->unsigned();
            $table->integer('user_id');
            $table->datetime('signin_datetime');
            $table->string('ip',128)->nullable();
            $table->string('user_agent',128)->nullable();
            $table->string('os',128)->nullable();
            $table->string('device',128)->nullable();
            $table->string('browser',128)->nullable();

            $table->timestamps();

            // //外部キー
            // $table->foreign('user_id')->references('id')->on('users')->onDeletes('no action');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('r_signinhistory');
    }
};
