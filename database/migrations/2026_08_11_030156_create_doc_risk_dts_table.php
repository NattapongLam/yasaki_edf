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
        Schema::create('doc_risk_dts', function (Blueprint $table) {
            $table->id('doc_risk_dts_id');
            $table->unsignedBigInteger('doc_risk_hds_id');
            $table->foreign('doc_risk_hds_id')->references('doc_risk_hds_id')->on('doc_risk_hds')->onDelete('cascade');
            $table->string('doc_risk_dts_issue');
            $table->string('doc_risk_dts_effect');
            $table->string('doc_risk_dts_control');
            $table->integer('doc_risk_dts_likelihood');
            $table->integer('doc_risk_dts_impact');
            $table->integer('doc_risk_dts_score');
            $table->string('doc_risk_dts_violence');
            $table->date('doc_risk_dts_chance')->nullable();
            $table->date('doc_risk_dts_period')->nullable();
            $table->date('doc_risk_dts_responsible')->nullable();
            $table->boolean('doc_risk_dts_flag')->default(true);
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
        Schema::dropIfExists('doc_risk_dts');
    }
};
