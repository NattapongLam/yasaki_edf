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
        Schema::create('ap_vendor_lists', function (Blueprint $table) {
            $table->id('ap_vendor_lists_id');
            $table->unsignedBigInteger('ap_vendor_groups_id');
            $table->foreign('ap_vendor_groups_id')->references('ap_vendor_groups_id')->on('ap_vendor_groups')->onDelete('cascade');
            $table->BigInteger('acc_companytype_id');
            $table->string('ap_vendor_lists_code');
            $table->string('ap_vendor_lists_name1');
            $table->string('ap_vendor_lists_name2')->nullable();
            $table->BigInteger('other_countries_id');
            $table->BigInteger('other_provinces_id');
            $table->BigInteger('other_districts_id');
            $table->BigInteger('other_sub_districts_id');
            $table->string('ap_vendor_lists_address1');
            $table->string('ap_vendor_lists_bankname')->nullable();
            $table->string('ap_vendor_lists_banknumber')->nullable();
            $table->BigInteger('acc_companybranch_id')->nullable();
            $table->string('ap_vendor_lists_branchnumber')->nullable();
            $table->string('ap_vendor_lists_taxid')->nullable();
            $table->integer('ap_vendor_lists_credit')->nullable();
            $table->string('ap_vendor_lists_tel');
            $table->string('ap_vendor_lists_email')->nullable();
            $table->string('ap_vendor_lists_lineid')->nullable();
            $table->string('ap_vendor_lists_contact')->nullable();            
            $table->boolean('ap_vendor_lists_flag')->default(true);   
            $table->string('ap_vendor_lists_file1')->nullable();     
            $table->string('ap_vendor_lists_file2')->nullable(); 
            $table->string('ap_vendor_lists_file3')->nullable();      
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
        Schema::dropIfExists('ap_vendor_lists');
    }
};
