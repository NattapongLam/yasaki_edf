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
        Schema::create('calibration_lists', function (Blueprint $table) {
            $table->id('calibration_lists_id');
            $table->unsignedBigInteger('calibration_categories_id');
            $table->foreign('calibration_categories_id')->references('calibration_categories_id')->on('calibration_categories')->onDelete('cascade');
            $table->unsignedBigInteger('calibration_groups_id');
            $table->foreign('calibration_groups_id')->references('calibration_groups_id')->on('calibration_groups')->onDelete('cascade');
            $table->unsignedBigInteger('calibration_types_id');
            $table->foreign('calibration_types_id')->references('calibration_types_id')->on('calibration_types')->onDelete('cascade');
            $table->string('calibration_lists_code');
            $table->string('calibration_lists_name1');
            $table->string('calibration_lists_name2')->nullable();
            $table->string('calibration_lists_serialno')->nullable();
            $table->BigInteger('ap_vendor_lists_id')->nullable();
            $table->string('calibration_lists_location')->nullable();
            $table->string('calibration_lists_reamrk')->nullable();
            $table->date('calibration_lists_date')->nullable();
            $table->date('calibration_lists_expirationdate')->nullable();
            $table->date('calibration_lists_calibrationdate')->nullable();
            $table->date('calibration_lists_nextdate')->nullable();
            $table->integer('calibration_lists_day')->nullable();
            $table->decimal('calibration_lists_areaofuse', 20, 4)->default(0);
            $table->decimal('calibration_lists_areaofuse_add', 20, 4)->default(0);
            $table->decimal('calibration_lists_areaofuse_del', 20, 4)->default(0);
            $table->decimal('calibration_lists_measuringrange', 20, 4)->default(0);
            $table->decimal('calibration_lists_measuringrange_add', 20, 4)->default(0);
            $table->decimal('calibration_lists_measuringrange_del', 20, 4)->default(0);
            $table->decimal('calibration_lists_precision', 20, 4)->default(0);
            $table->decimal('calibration_lists_resolution', 20, 4)->default(0);
            $table->string('calibration_lists_person')->nullable();
            $table->string('calibration_lists_status')->nullable();
            $table->string('calibration_lists_verify')->nullable();
            $table->string('calibration_lists_file1')->nullable();
            $table->string('calibration_lists_file2')->nullable();
            $table->string('calibration_lists_file3')->nullable();
            $table->string('calibration_lists_file4')->nullable();
            $table->decimal('calibration_lists_temperature', 20, 4)->default(0);
            $table->decimal('calibration_lists_temperature_add', 20, 4)->default(0);
            $table->decimal('calibration_lists_temperature_del', 20, 4)->default(0);
            $table->decimal('calibration_lists_humidity', 20, 4)->default(0);
            $table->decimal('calibration_lists_humidity_add', 20, 4)->default(0);
            $table->decimal('calibration_lists_humidity_del', 20, 4)->default(0);
            $table->decimal('calibration_lists_uncertainty', 20, 4)->default(0);
            $table->string('calibration_lists_markingorshape')->nullable();
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
        Schema::dropIfExists('calibration_lists');
    }
};
