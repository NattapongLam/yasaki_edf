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
        Schema::create('customer_satisfaction_surveys', function (Blueprint $table) {
            $table->id('customer_satisfaction_surveys_id');
            $table->unsignedBigInteger('ar_customer_lists_id');
            $table->foreign('ar_customer_lists_id')->references('ar_customer_lists_id')->on('ar_customer_lists')->onDelete('cascade');
            $table->string('ar_customer_lists_name');
            $table->string('ar_customer_lists_contact');
            $table->string('ar_customer_lists_tel');
            $table->date('customer_satisfaction_surveys_date');
            $table->integer('quality_1'); 
            $table->integer('quality_2'); 
            $table->integer('quality_3'); 
            $table->integer('delivery_1'); 
            $table->integer('delivery_2'); 
            $table->integer('delivery_3'); 
            $table->integer('personnel_1'); 
            $table->integer('personnel_2'); 
            $table->integer('personnel_3'); 
            $table->integer('communication_1'); 
            $table->integer('communication_2'); 
            $table->integer('communication_3'); 
            $table->string('suggestions_1')->nullable();
            $table->string('suggestions_2')->nullable();
            $table->boolean('customer_satisfaction_surveys_flag')->default(true);
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
        Schema::dropIfExists('customer_satisfaction_surveys');
    }
};
