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
        Schema::create('user2hogosha', function (Blueprint $table) {
            $table->collation = 'utf8mb4_general_ci';

            $table->id();
            $table->biginteger('user_id')->unsigned();
            $table->string('HogoshaCd',8);

            $table->timestamps();
            $table->softDeletes();
            
            //外部キーの設定
            $table->foreign('user_id')->references('id')->on('users')->onDeletes('no action');
            $table->foreign('HogoshaCd')->references('HogoshaCd')->on('m_hogosha')->onDeletes('no action');

            // このユニークキーがあることで、ソフトデリート後の挿入ができなくなった
            // $table->unique('user_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user2hogosha');
    }
};
