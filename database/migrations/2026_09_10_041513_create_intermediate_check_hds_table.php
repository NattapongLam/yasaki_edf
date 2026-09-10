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
        Schema::create('intermediate_check_hds', function (Blueprint $table) {
            $table->id('intermediate_check_hds_id');
            $table->string('instrument_name');
            $table->string('specification')->nullable();
            $table->string('model');
            $table->string('serial_number');
            $table->date('cal_date');
            $table->string('certificate_no');
            $table->string('refer_doc');
            $table->string('test_range_voltage');
            $table->boolean('intermediate_check_hds_flag')->default(true);
            $table->string('creator');
            $table->date('created_date');
            $table->string('stat_c_test1_mean');
            $table->string('stat_c_test2_mean');
            $table->string('stat_c_test1_var');
            $table->string('stat_c_test2_var');
            $table->string('stat_c_test1_obs');
            $table->string('stat_c_test2_obs');
            $table->string('stat_rh_test1_mean');
            $table->string('stat_rh_test2_mean');
            $table->string('stat_rh_test1_var');
            $table->string('stat_rh_test2_var');
            $table->string('stat_rh_test1_obs');
            $table->string('stat_rh_test2_obs');
            $table->string('summary_result');
            $table->string('approver')->nullable();
            $table->date('approved_date')->nullable();           
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
        Schema::dropIfExists('intermediate_check_hds');
    }
};
