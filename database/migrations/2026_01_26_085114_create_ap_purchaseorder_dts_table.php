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
        Schema::create('ap_purchaseorder_dts', function (Blueprint $table) {
            $table->id('ap_purchaseorder_dts_id');
            $table->unsignedBigInteger('ap_purchaseorder_hds_id');
            $table->foreign('ap_purchaseorder_hds_id')->references('ap_purchaseorder_hds_id')->on('ap_purchaseorder_hds')->onDelete('cascade');
            $table->integer('ap_purchaseorder_dts_listno');
            $table->BigInteger('ap_purchaserequest_dts_id');
            $table->BigInteger('wh_product_lists_id');
            $table->string('wh_product_lists_code');
            $table->string('wh_product_lists_name');
            $table->string('wh_product_lists_unit');
            $table->decimal('acc_discount_qty', 18, 2)->default(0);
            $table->decimal('ap_purchaseorder_dts_qty', 18, 2)->default(0);
            $table->decimal('ap_purchaseorder_dts_price', 20, 4)->default(0);
            $table->decimal('ap_purchaseorder_dts_base', 20, 4)->default(0);
            $table->decimal('ap_purchaseorder_dts_vat', 20, 4)->default(0);
            $table->decimal('ap_purchaseorder_dts_net', 20, 4)->default(0);
            $table->decimal('ap_purchaseorder_dts_dis', 20, 4)->default(0);
            $table->decimal('ap_purchaseorder_dts_amount', 20, 4)->default(0);
            $table->date('ap_purchaseorder_dts_duedate');
            $table->string('ap_purchaseorder_dts_remark')->nullable();
            $table->BigInteger('ms_allocate_id');
            $table->string('ap_purchaserequest_hds_docuno');
            $table->decimal('ap_purchaserequest_dts_qty', 18, 2)->default(0);
            $table->boolean('ap_purchaseorder_dts_flag')->default(true);
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
        Schema::dropIfExists('ap_purchaseorder_dts');
    }
};
