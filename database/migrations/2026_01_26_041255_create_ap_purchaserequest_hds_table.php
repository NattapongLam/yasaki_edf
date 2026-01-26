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
        Schema::create('ap_purchaserequest_hds', function (Blueprint $table) {
            $table->id('ap_purchaserequest_hds_id');
            $table->date('ap_purchaserequest_hds_date');
            $table->string('ap_purchaserequest_hds_docuno');
            $table->integer('ap_purchaserequest_hds_number');
            $table->BigInteger('ap_purchaserequest_statuses_id');
            $table->BigInteger('ms_allocate_id');
            $table->string('ap_purchaserequest_hds_remark')->nullable();
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
        Schema::dropIfExists('ap_purchaserequest_hds');
    }
};
