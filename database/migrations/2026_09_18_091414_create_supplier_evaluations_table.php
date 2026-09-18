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
        Schema::create('supplier_evaluations', function (Blueprint $table) {
            $table->id('supplier_evaluations_id');
            $table->unsignedBigInteger('ap_vendor_lists_id');
            $table->foreign('ap_vendor_lists_id')->references('ap_vendor_lists_id')->on('ap_vendor_lists')->onDelete('cascade');
            $table->string('supplier');
            $table->date('evaluation_date');
            $table->string('goods_services');
            $table->string('period_evaluated');
            $table->integer('score_1'); 
            $table->string('score_from_1')->nullable();
            $table->string('notes_1')->nullable();
            $table->integer('score_2'); 
            $table->string('score_from_2')->nullable();
            $table->string('notes_2')->nullable();
            $table->integer('score_3'); 
            $table->string('score_from_3')->nullable();
            $table->string('notes_3')->nullable();
            $table->integer('score_4'); 
            $table->string('score_from_4')->nullable();
            $table->string('notes_4')->nullable();
            $table->integer('score_5'); 
            $table->string('score_from_5')->nullable();
            $table->string('notes_5')->nullable();
            $table->string('decision')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->boolean('supplier_evaluations_flag')->default(true);
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
        Schema::dropIfExists('supplier_evaluations');
    }
};
