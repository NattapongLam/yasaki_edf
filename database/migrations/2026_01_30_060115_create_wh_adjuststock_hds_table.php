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
        Schema::create('wh_adjuststock_hds', function (Blueprint $table) {
            $table->id('wh_adjuststock_hds_id');
            $table->date('wh_adjuststock_hds_date');
            $table->string('wh_adjuststock_hds_docuno');
            $table->integer('wh_adjuststock_hds_number');
            $table->BigInteger('wh_adjuststock_statuses_id');
            $table->BigInteger('wh_warehouses_id');
            $table->string('wh_adjuststock_hds_remark')->nullable();
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
        Schema::dropIfExists('wh_adjuststock_hds');
    }
};
