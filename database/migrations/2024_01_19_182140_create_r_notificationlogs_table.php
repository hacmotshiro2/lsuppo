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
        Schema::create('r_notificationlogs', function (Blueprint $table) {

            $table->collation = 'utf8mb4_general_ci';

            $table->bigIncrements('id')->unsigned();
            $table->biginteger('user_id')->unsigned();
            $table->string('name',255)->nullable();
            $table->string('email',255)->nullable();
            $table->string('line_user_id',64)->nullable();
            $table->tinyInteger('notification_type')->nullable();
            $table->string('notification_class',128)->nullable();
            $table->string('channel',40)->nullable();

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
        Schema::dropIfExists('r_notificationlogs');
    }
};
