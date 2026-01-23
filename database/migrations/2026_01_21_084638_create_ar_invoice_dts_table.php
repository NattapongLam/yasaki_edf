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
        Schema::create('ar_invoice_dts', function (Blueprint $table) {
            $table->id('ar_invoice_dts_id');
            $table->unsignedBigInteger('ar_invoice_hds_id');
            $table->foreign('ar_invoice_hds_id')->references('ar_invoice_hds_id')->on('ar_invoice_hds')->onDelete('cascade');
            $table->integer('ar_invoice_dts_listno');
            $table->BigInteger('wh_product_lists_id');
            $table->string('wh_product_lists_code');
            $table->string('wh_product_lists_name');
            $table->string('wh_product_lists_unit');
            $table->decimal('ar_invoice_dts_qty', 18, 2)->default(0);
            $table->decimal('ar_invoice_dts_price', 20, 4)->default(0);
            $table->decimal('ar_invoice_dts_discount', 20, 4)->default(0);
            $table->decimal('ar_invoice_dts_amount', 20, 4)->default(0);
            $table->string('ar_invoice_dts_remark')->nullable();
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
        Schema::dropIfExists('ar_invoice_dts');
    }
};
