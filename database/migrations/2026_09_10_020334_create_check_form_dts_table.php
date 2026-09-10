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
        Schema::create('check_form_dts', function (Blueprint $table) {
            $table->id('check_form_dts_id');
            $table->unsignedBigInteger('check_form_hds_id');
            $table->foreign('check_form_hds_id')->references('check_form_hds_id')->on('check_form_hds')->onDelete('cascade');
            $table->date('check_date');
            $table->integer('check_form_dts_no'); 
            $table->string('x1')->nullable();
            $table->string('x2')->nullable();
            $table->string('x3')->nullable();
            $table->string('x_bar')->nullable();
            $table->string('min_spec')->nullable();
            $table->string('max_spec')->nullable();
            $table->string('pass_fail')->nullable();
            $table->string('checker')->nullable();
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
        Schema::dropIfExists('check_form_dts');
    }
};
