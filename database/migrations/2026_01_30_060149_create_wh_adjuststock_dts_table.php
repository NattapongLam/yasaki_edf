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
        Schema::create('wh_adjuststock_dts', function (Blueprint $table) {
            $table->id('wh_adjuststock_dts_id');
            $table->unsignedBigInteger('wh_adjuststock_hds_id');
            $table->foreign('wh_adjuststock_hds_id')->references('wh_adjuststock_hds_id')->on('wh_adjuststock_hds')->onDelete('cascade');
            $table->integer('wh_adjuststock_dts_listno');   
            $table->BigInteger('wh_product_lists_id');
            $table->string('wh_product_lists_code');
            $table->string('wh_product_lists_name');
            $table->string('wh_product_lists_unit');
            $table->decimal('wh_adjuststock_dts_qty', 18, 2)->default(0);
            $table->decimal('wh_adjuststock_dts_cost', 20, 4)->default(0);  
            $table->decimal('stc_stockcard_qty', 18, 2)->default(0);
            $table->boolean('wh_adjuststock_dts_flag')->default(true);
            $table->string('person_at');
            $table->string('poststock');     
            $table->integer('stockflag')->default(1);   
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
        Schema::dropIfExists('wh_adjuststock_dts');
    }
};
