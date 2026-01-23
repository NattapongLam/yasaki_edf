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
        Schema::create('ar_saleorder_dts', function (Blueprint $table) {
            $table->id('ar_saleorder_dts_id');
            $table->unsignedBigInteger('ar_saleorder_hds_id');
            $table->foreign('ar_saleorder_hds_id')->references('ar_saleorder_hds_id')->on('ar_saleorder_hds')->onDelete('cascade');
            $table->integer('ar_saleorder_dts_listno');
            $table->BigInteger('wh_product_lists_id');
            $table->string('wh_product_lists_code');
            $table->string('wh_product_lists_name');
            $table->string('wh_product_lists_unit');
            $table->decimal('acc_discount_qty', 18, 2)->default(0);
            $table->decimal('ar_saleorder_dts_qty', 18, 2)->default(0);
            $table->decimal('ar_saleorder_dts_price', 20, 4)->default(0);
            $table->decimal('ar_saleorder_dts_base', 20, 4)->default(0);
            $table->decimal('ar_saleorder_dts_vat', 20, 4)->default(0);
            $table->decimal('ar_saleorder_dts_net', 20, 4)->default(0);
            $table->decimal('ar_saleorder_dts_dis', 20, 4)->default(0);
            $table->decimal('ar_saleorder_dts_amount', 20, 4)->default(0);
            $table->string('ar_saleorder_dts_remark')->nullable();
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
        Schema::dropIfExists('ar_saleorder_dts');
    }
};
