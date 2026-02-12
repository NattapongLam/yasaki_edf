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
        Schema::create('machinery_checksheet_dts', function (Blueprint $table) {
            $table->id('machinery_checksheet_dts_id');
            $table->unsignedBigInteger('machinery_checksheet_hds_id');
            $table->foreign('machinery_checksheet_hds_id')->references('machinery_checksheet_hds_id')->on('machinery_checksheet_hds')->onDelete('cascade');
            $table->integer('machinery_checksheet_dts_listno');   
            $table->string('machinery_checksheet_dts_remark');
            $table->boolean('machinery_checksheet_dts_flag')->default(true);
            $table->string('person_at');
            $table->boolean('action_01')->default(false);
            $table->boolean('action_02')->default(false);
            $table->boolean('action_03')->default(false);
            $table->boolean('action_04')->default(false);
            $table->boolean('action_05')->default(false);
            $table->boolean('action_06')->default(false);
            $table->boolean('action_07')->default(false);
            $table->boolean('action_08')->default(false);
            $table->boolean('action_09')->default(false);
            $table->boolean('action_10')->default(false);
            $table->boolean('action_11')->default(false);
            $table->boolean('action_12')->default(false);
            $table->boolean('action_13')->default(false);
            $table->boolean('action_14')->default(false);
            $table->boolean('action_15')->default(false);
            $table->boolean('action_16')->default(false);
            $table->boolean('action_17')->default(false);
            $table->boolean('action_18')->default(false);
            $table->boolean('action_19')->default(false);
            $table->boolean('action_20')->default(false);
            $table->boolean('action_21')->default(false);
            $table->boolean('action_22')->default(false);
            $table->boolean('action_23')->default(false);
            $table->boolean('action_24')->default(false);
            $table->boolean('action_25')->default(false);
            $table->boolean('action_26')->default(false);
            $table->boolean('action_27')->default(false);
            $table->boolean('action_28')->default(false);
            $table->boolean('action_29')->default(false);
            $table->boolean('action_30')->default(false);
            $table->boolean('action_31')->default(false);
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
        Schema::dropIfExists('machinery_checksheet_dts');
    }
};
