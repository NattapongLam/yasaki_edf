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
        Schema::create('calibration_plans', function (Blueprint $table) {
            $table->id('calibration_plans_id');
            $table->date('calibration_plans_date');
            $table->BigInteger('calibration_lists_id');
            $table->string('calibration_lists_code');
            $table->string('calibration_lists_name');
            $table->date('calibration_plans_resultdate')->nullable();
            $table->boolean('calibration_plans_plan')->default(true);
            $table->boolean('calibration_plans_action')->default(false);
            $table->string('calibration_plans_remark')->nullable();
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
        Schema::dropIfExists('calibration_plans');
    }
};
