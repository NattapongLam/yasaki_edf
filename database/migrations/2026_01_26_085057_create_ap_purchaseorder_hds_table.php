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
        Schema::create('ap_purchaseorder_hds', function (Blueprint $table) {
            $table->id('ap_purchaseorder_hds_id');
            $table->date('ap_purchaseorder_hds_date');
            $table->string('ap_purchaseorder_hds_docuno');
            $table->integer('ap_purchaseorder_hds_number');
            $table->BigInteger('ap_purchaseorder_statuses_id');
            $table->BigInteger('ap_vendor_lists_id');
            $table->string('ap_vendor_lists_code');
            $table->string('ap_vendor_lists_name');
            $table->string('ap_vendor_lists_address');
            $table->string('ap_vendor_lists_taxid')->nullable();
            $table->string('ap_vendor_lists_contact')->nullable();
            $table->string('ap_vendor_lists_tel');
            $table->string('ap_vendor_lists_email')->nullable();
            $table->integer('ap_vendor_lists_credit');
            $table->BigInteger('acc_typevats_id');
            $table->BigInteger('acc_currencies_id');
            $table->BigInteger('acc_discount_id');
            $table->decimal('acc_discount_qty', 18, 2)->default(0);
            $table->string('ap_purchaseorder_hds_remark')->nullable();
            $table->decimal('ap_purchaseorder_hds_base', 20, 4)->default(0);
            $table->decimal('ap_purchaseorder_hds_vat', 20, 4)->default(0);
            $table->decimal('ap_purchaseorder_hds_net', 20, 4)->default(0);
            $table->decimal('ap_purchaseorder_hds_dis', 20, 4)->default(0);
            $table->decimal('ap_purchaseorder_hds_amount', 20, 4)->default(0);
            $table->string('person_at');
            $table->date('approved_date')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('approved_remark')->nullable();
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
        Schema::dropIfExists('ap_purchaseorder_hds');
    }
};
