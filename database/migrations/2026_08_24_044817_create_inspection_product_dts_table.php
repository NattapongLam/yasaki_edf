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
        Schema::create('inspection_product_dts', function (Blueprint $table) {
            $table->id('inspection_product_dts_id');
            $table->unsignedBigInteger('inspection_product_hds_id');
            $table->foreign('inspection_product_hds_id')->references('inspection_product_hds_id')->on('inspection_product_hds')->onDelete('cascade');
            $table->integer('inspection_product_dts_listno'); 
            $table->string('inspection_product_dts_name');
            $table->string('inspection_product_dts_standard');
            $table->string('inspection_product_dts_result');
            $table->string('inspection_product_dts_status');
            $table->boolean('inspection_product_dts_flag')->default(true);
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
        Schema::dropIfExists('inspection_product_dts');
    }
};
