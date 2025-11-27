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
        Schema::create('ar_customer_lists', function (Blueprint $table) {
            $table->id('ar_customer_lists_id');
            $table->unsignedBigInteger('ar_customer_groups_id');
            $table->foreign('ar_customer_groups_id')->references('ar_customer_groups_id')->on('ar_customer_groups')->onDelete('cascade');
            $table->BigInteger('acc_companytype_id');
            $table->string('ar_customer_lists_code');
            $table->string('ar_customer_lists_name1');
            $table->string('ar_customer_lists_name2')->nullable();
            $table->BigInteger('other_countries_id');
            $table->BigInteger('other_provinces_id');
            $table->BigInteger('other_districts_id');
            $table->BigInteger('other_sub_districts_id');
            $table->string('ar_customer_lists_address1');
            $table->string('ar_customer_lists_address2')->nullable();
            $table->BigInteger('acc_companybranch_id')->nullable();
            $table->string('ar_customer_lists_branchnumber')->nullable();
            $table->string('ar_customer_lists_taxid')->nullable();
            $table->integer('ar_customer_lists_credit')->nullable();
            $table->string('ar_customer_lists_tel');
            $table->string('ar_customer_lists_email')->nullable();
            $table->string('ar_customer_lists_lineid')->nullable();
            $table->string('ar_customer_lists_contact')->nullable();
            $table->string('ar_customer_lists_sale')->nullable();
            $table->boolean('ar_customer_lists_flag')->default(true);   
            $table->string('ar_customer_lists_file1')->nullable();         
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
        Schema::dropIfExists('ar_customer_lists');
    }
};
