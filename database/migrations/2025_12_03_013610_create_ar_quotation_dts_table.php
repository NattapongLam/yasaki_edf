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
        Schema::create('ar_quotation_dts', function (Blueprint $table) {
            $table->id('ar_quotation_dts_id');
            $table->unsignedBigInteger('ar_quotation_hds_id');
            $table->foreign('ar_quotation_hds_id')->references('ar_quotation_hds_id')->on('ar_quotation_hds')->onDelete('cascade');
            $table->integer('ar_quotation_dts_listno');
            $table->BigInteger('wh_product_lists_id');
            $table->string('wh_product_lists_code');
            $table->string('wh_product_lists_name');
            $table->string('wh_product_lists_unit');
            $table->decimal('acc_discount_qty', 18, 2)->default(0);
            $table->decimal('ar_quotation_dts_qty', 18, 2)->default(0);
            $table->decimal('ar_quotation_dts_base', 20, 4)->default(0);
            $table->decimal('ar_quotation_dts_vat', 20, 4)->default(0);
            $table->decimal('ar_quotation_dts_net', 20, 4)->default(0);
            $table->decimal('ar_quotation_dts_dis', 20, 4)->default(0);
            $table->decimal('ar_quotation_dts_amount', 20, 4)->default(0);
            $table->string('ar_quotation_hds_remark')->nullable();
            $table->boolean('ar_quotation_dts_flag')->default(true);
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
        Schema::dropIfExists('ar_quotation_dts');
    }
};
