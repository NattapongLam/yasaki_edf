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
        Schema::create('calibration_checksheet_hds', function (Blueprint $table) {
            $table->id('calibration_checksheet_hds_id');
            $table->date('calibration_checksheet_hds_date');
            $table->BigInteger('calibration_lists_id');
            $table->string('calibration_lists_code');
            $table->string('calibration_lists_name');
            $table->string('calibration_checksheet_hds_remark')->nullable();
            $table->boolean('calibration_checksheet_hds_flag')->default(true);
            $table->string('person_at');
            $table->date('approved_date')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('approved_remark')->nullable();
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
        Schema::dropIfExists('calibration_checksheet_hds');
    }
};
