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
        Schema::create('ar_requestorder_hds', function (Blueprint $table) {
            $table->id('ar_requestorder_hds_id');
            $table->date('ar_requestorder_hds_date');
            $table->string('ar_requestorder_hds_docuno');
            $table->integer('ar_requestorder_hds_number');
            $table->BigInteger('ar_requestorder_statuses_id');
            $table->string('ar_requestorder_hds_customer');
            $table->string('ar_requestorder_hds_contact');
            $table->string('ar_requestorder_hd_remark')->nullable();
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
        Schema::dropIfExists('ar_requestorder_hds');
    }
};
