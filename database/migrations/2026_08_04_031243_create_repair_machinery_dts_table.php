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
        Schema::create('repair_machinery_dts', function (Blueprint $table) {
            $table->id('repair_machinery_dts_id');
            $table->unsignedBigInteger('repair_machinery_hds_id');
            $table->foreign('repair_machinery_hds_id')->references('repair_machinery_hds_id')->on('repair_machinery_hds')->onDelete('cascade');
            $table->integer('repair_machinery_dts_listno');
            $table->string('repair_machinery_dts_part');
            $table->string('repair_machinery_dts_remark');
            $table->boolean('repair_machinery_dts_flag')->default(true);
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
        Schema::dropIfExists('repair_machinery_dts');
    }
};
