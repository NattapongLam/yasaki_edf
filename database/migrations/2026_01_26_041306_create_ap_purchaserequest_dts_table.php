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
        Schema::create('ap_purchaserequest_dts', function (Blueprint $table) {
            $table->id('ap_purchaserequest_dts_id');
            $table->unsignedBigInteger('ap_purchaserequest_hds_id');
            $table->foreign('ap_purchaserequest_hds_id')->references('ap_purchaserequest_hds_id')->on('ap_purchaserequest_hds')->onDelete('cascade');
            $table->integer('ap_purchaserequest_dts_listno');
            $table->BigInteger('wh_product_lists_id');
            $table->string('wh_product_lists_code');
            $table->string('wh_product_lists_name');
            $table->string('wh_product_lists_unit');
            $table->decimal('ap_purchaserequest_dts_qty', 18, 2)->default(0);
            $table->date('ap_purchaserequest_hds_duedate');
            $table->string('ap_purchaserequest_dts_remark')->nullable();
            $table->boolean('ap_purchaserequest_dts_flag')->default(true);
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
        Schema::dropIfExists('ap_purchaserequest_dts');
    }
};
