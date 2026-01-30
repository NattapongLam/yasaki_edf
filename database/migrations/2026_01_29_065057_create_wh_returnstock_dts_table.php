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
        Schema::create('wh_returnstock_dts', function (Blueprint $table) {
            $table->id('wh_returnstock_dts_id');
            $table->unsignedBigInteger('wh_returnstock_hds_id');
            $table->foreign('wh_returnstock_hds_id')->references('wh_returnstock_hds_id')->on('wh_returnstock_hds')->onDelete('cascade');
            $table->integer('wh_returnstock_dts_listno');          
            $table->BigInteger('wh_product_lists_id');
            $table->string('wh_product_lists_code');
            $table->string('wh_product_lists_name');
            $table->string('wh_product_lists_unit');
            $table->decimal('wh_returnstock_dts_qty', 18, 2)->default(0);
            $table->decimal('wh_returnstock_dts_cost', 20, 4)->default(0);
            $table->BigInteger('wh_issuestock_dts_id');
            $table->decimal('wh_issuestock_dts_qty', 18, 2)->default(0);
            $table->boolean('wh_returnstock_dts_flag')->default(true);
            $table->string('person_at');
            $table->string('poststock');
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
        Schema::dropIfExists('wh_returnstock_dts');
    }
};
