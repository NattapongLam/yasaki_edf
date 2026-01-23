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
        Schema::create('ar_requestorder_dts', function (Blueprint $table) {
            $table->id('ar_requestorder_dts_id');
            $table->unsignedBigInteger('ar_requestorder_hds_id');
            $table->foreign('ar_requestorder_hds_id')->references('ar_requestorder_hds_id')->on('ar_requestorder_hds')->onDelete('cascade');
            $table->integer('ar_requestorder_dts_listno');
            $table->string('ar_requestorder_dts_product');
            $table->string('ar_requestorder_hds_remark');
            $table->integer('ar_requestorder_dts_qty');
            $table->boolean('ar_requestorder_dts_flag')->default(true);
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
        Schema::dropIfExists('ar_requestorder_dts');
    }
};
