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
        Schema::create('intermediate_check_dts', function (Blueprint $table) {
            $table->id('intermediate_check_dts_id');
            $table->unsignedBigInteger('intermediate_check_hds_id');
            $table->foreign('intermediate_check_hds_id')->references('intermediate_check_hds_id')->on('intermediate_check_hds')->onDelete('cascade');
            $table->string('point');
            $table->string('bc_n1_c');
            $table->string('bc_n1_rh');
            $table->string('bc_n2_c');
            $table->string('bc_n2_rh');
            $table->string('bc_n3_c');
            $table->string('bc_n3_rh');
            $table->string('t1_n1_c');
            $table->string('t1_n1_rh');
            $table->string('t1_n2_c');
            $table->string('t1_n2_rh');
            $table->string('t1_n3_c');
            $table->string('t1_n3_rh');
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
        Schema::dropIfExists('intermediate_check_dts');
    }
};
