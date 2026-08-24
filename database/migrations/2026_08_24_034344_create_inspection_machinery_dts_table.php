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
        Schema::create('inspection_machinery_dts', function (Blueprint $table) {
            $table->id('inspection_machinery_dts_id');
            $table->unsignedBigInteger('inspection_machinery_hds_id');
            $table->foreign('inspection_machinery_hds_id')->references('inspection_machinery_hds_id')->on('inspection_machinery_hds')->onDelete('cascade');
            $table->integer('inspection_machinery_dts_listno'); 
            $table->string('inspection_machinery_dts_name');
            $table->string('inspection_machinery_dts_standard');
            $table->string('inspection_machinery_dts_result');
            $table->string('inspection_machinery_dts_status');
            $table->boolean('inspection_machinery_dts_flag')->default(true);
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
        Schema::dropIfExists('inspection_machinery_dts');
    }
};
