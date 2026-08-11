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
        Schema::create('doc_risk_hds', function (Blueprint $table) {
            $table->id('doc_risk_hds_id');
            $table->string('doc_risk_hds_type');
            $table->string('doc_risk_hds_agency');
            $table->string('doc_risk_hds_person');
            $table->date('doc_risk_hds_date');
            $table->string('prepared_by');
            $table->date('prepared_date');
            $table->string('approved_by')->nullable();
            $table->date('approved_date')->nullable();
            $table->boolean('doc_risk_hds_flag')->default(true);
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
        Schema::dropIfExists('doc_risk_hds');
    }
};
