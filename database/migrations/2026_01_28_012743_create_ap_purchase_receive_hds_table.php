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
        Schema::create('ap_purchase_receive_hds', function (Blueprint $table) {
            $table->id('ap_purchase_receive_hds_id');
            $table->date('ap_purchase_receive_hds_date');
            $table->string('ap_purchase_receive_hds_docuno');
            $table->integer('ap_purchase_receive_hds_number');
            $table->BigInteger('ap_purchase_receive_statuses_id');
            $table->BigInteger('ap_purchaseorder_hds_id');
            $table->BigInteger('ap_vendor_lists_id');
            $table->BigInteger('wh_warehouses_id');
            $table->string('ap_vendor_lists_code');
            $table->string('ap_vendor_lists_name');
            $table->string('ap_vendor_lists_address');
            $table->string('ap_vendor_lists_taxid')->nullable();
            $table->integer('ap_vendor_lists_credit');
            $table->BigInteger('acc_typevats_id');
            $table->BigInteger('acc_currencies_id');
            $table->BigInteger('acc_discount_id');
            $table->decimal('acc_discount_qty', 18, 2)->default(0);
            $table->string('ap_purchase_receive_hds_remark')->nullable();
            $table->decimal('ap_purchase_receive_hds_base', 20, 4)->default(0);
            $table->decimal('ap_purchase_receive_hds_vat', 20, 4)->default(0);
            $table->decimal('ap_purchase_receive_hds_net', 20, 4)->default(0);
            $table->decimal('ap_purchase_receive_hds_dis', 20, 4)->default(0);
            $table->decimal('ap_purchase_receive_hds_amount', 20, 4)->default(0);
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
        Schema::dropIfExists('ap_purchase_receive_hds');
    }
};
