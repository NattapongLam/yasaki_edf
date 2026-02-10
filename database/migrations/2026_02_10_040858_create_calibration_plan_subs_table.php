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
        Schema::create('calibration_plan_subs', function (Blueprint $table) {
            $table->id('calibration_plan_subs_id');
            $table->unsignedBigInteger('calibration_plans_id');
            $table->foreign('calibration_plans_id')->references('calibration_plans_id')->on('calibration_plans')->onDelete('cascade');
            $table->BigInteger('calibration_lists_id');
            $table->date('calibration_plan_subs_date');
            $table->decimal('calibration_plan_subs_areaofuse', 20, 4)->default(0);
            $table->decimal('calibration_plan_subs_areaofuse_add', 20, 4)->default(0);
            $table->decimal('calibration_plan_subs_areaofuse_del', 20, 4)->default(0);
            $table->decimal('calibration_plan_subs_precision', 20, 4)->default(0);
            $table->decimal('calibration_plan_subs_measuringrange', 20, 4)->default(0);            
            $table->decimal('calibration_plan_subs_measuringrange_add', 20, 4)->default(0);
            $table->decimal('calibration_plan_subs_measuringrange_del', 20, 4)->default(0);
            $table->decimal('calibration_plan_subs_resolution', 20, 4)->default(0);
            $table->decimal('calibration_plan_subs_temperature', 20, 4)->default(0);
            $table->decimal('calibration_plan_subs_temperature_add', 20, 4)->default(0);
            $table->decimal('calibration_plan_subs_temperature_del', 20, 4)->default(0);
            $table->decimal('calibration_plan_subs_uncertainty', 20, 4)->default(0);
            $table->decimal('calibration_plan_subs_humidity', 20, 4)->default(0);
            $table->decimal('calibration_plan_subs_humidity_add', 20, 4)->default(0);
            $table->decimal('calibration_plan_subs_humidity_del', 20, 4)->default(0);         
            $table->string('calibration_plan_subs_markingorshape')->nullable();
            $table->string('calibration_plan_subs_remark')->nullable();
            $table->string('calibration_plan_subs_file1')->nullable();
            $table->string('calibration_plan_subs_file2')->nullable();
            $table->boolean('calibration_plan_subs_flag')->default(true);
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
        Schema::dropIfExists('calibration_plan_subs');
    }
};
