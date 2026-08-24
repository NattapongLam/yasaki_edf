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
        Schema::create('inspection_calibration_dts', function (Blueprint $table) {
            $table->id('inspection_calibration_dts_id');
            $table->unsignedBigInteger('inspection_calibration_hds_id');
            $table->foreign('inspection_calibration_hds_id')->references('inspection_calibration_hds_id')->on('inspection_calibration_hds')->onDelete('cascade');
            $table->integer('inspection_calibration_dts_listno'); 
            $table->string('inspection_calibration_dts_name');
            $table->string('inspection_calibration_dts_standard');
            $table->string('inspection_calibration_dts_result');
            $table->string('inspection_calibration_dts_status');
            $table->boolean('inspection_calibration_dts_flag')->default(true);
            $table->string('person_at');
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
        Schema::dropIfExists('inspection_calibration_dts');
    }
};
