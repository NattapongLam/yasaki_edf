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
        Schema::create('customer_complaints_lists', function (Blueprint $table) {
            $table->id('customer_complaints_lists_id');
            $table->date('customer_complaints_lists_date');
            $table->string('customer_complaints_lists_refdocuno');
            $table->BigInteger('ar_customer_lists_id');
            $table->string('customer_complaints_lists_details');
            $table->boolean('customer_complaints_lists_flag')->default(true);
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
        Schema::dropIfExists('customer_complaints_lists');
    }
};
