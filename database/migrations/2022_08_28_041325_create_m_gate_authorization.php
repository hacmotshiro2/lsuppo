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
        Schema::create('m_gateAuthorization', function (Blueprint $table) {
            $table->collation = 'utf8mb4_general_ci';

            $table->string('Path',80);
            $table->string('AuthorizedGate',800)->nullable();
            $table->string('UpdateGamen',128);
            $table->string('UpdateSystem',128);

            $table->timestamps();

            $table->primary('Path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_gateAuthorization');
    }
};
