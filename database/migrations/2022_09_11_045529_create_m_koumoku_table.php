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
        Schema::create('m_koumoku', function (Blueprint $table) {
            $table->collation = 'utf8mb4_general_ci';

            $table->Integer('Shubetu')->unsigned();
            $table->string('Code',3);
            $table->string('Value',40);
            $table->string('Hosoku',128)->nullable();
            $table->string('UpdateGamen',128);
            $table->string('UpdateSystem',128);

            $table->timestamps();
            $table->softDeletes();

            //主キー(複合)
            $table->primary(['Shubetu','Code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_koumoku');
    }
};
