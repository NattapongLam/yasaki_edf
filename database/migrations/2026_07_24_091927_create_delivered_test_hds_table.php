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
        Schema::create('delivered_test_hds', function (Blueprint $table) {
            $table->id('delivered_test_hds_id');
            $table->date('delivered_test_hds_date');
            $table->string('delivered_test_hds_docuno');
            $table->integer('delivered_test_hds_number');
            $table->BigInteger('delivered_test_statuses_id');
            $table->string('delivered_test_hds_customer');
            $table->string('delivered_test_hds_contact');
            $table->string('delivered_test_hds_remark')->nullable();
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
        Schema::dropIfExists('delivered_test_hds');
    }
};
