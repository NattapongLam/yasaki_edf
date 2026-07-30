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
        Schema::create('delivered_test_dts', function (Blueprint $table) {
            $table->id('delivered_test_dts_id');
            $table->unsignedBigInteger('delivered_test_hds_id');
            $table->foreign('delivered_test_hds_id')->references('delivered_test_hds_id')->on('delivered_test_hds')->onDelete('cascade');
            $table->integer('delivered_test_dts_listno');
            $table->string('delivered_test_dts_remark');
            $table->integer('delivered_test_dts_qty');
            $table->boolean('delivered_test_dts_flag')->default(true);
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
        Schema::dropIfExists('delivered_test_dts');
    }
};
