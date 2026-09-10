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
        Schema::create('check_form_hds', function (Blueprint $table) {
            $table->id('check_form_hds_id');
            $table->string('instrument_name');
            $table->string('specification')->nullable();
            $table->string('model');
            $table->string('serial_number');
            $table->date('cal_date');
            $table->string('certificate_no');
            $table->string('refer_doc');
            $table->string('test_range_voltage');
            $table->boolean('check_form_hds_flag')->default(true);
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
        Schema::dropIfExists('check_form_hds');
    }
};
