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
        Schema::create('doc_cars', function (Blueprint $table) {
            $table->id('doc_cars_id');
            $table->string('doc_cars_relevant');
            $table->date('doc_cars_date');
            $table->string('doc_cars_docuno');
            $table->string('doc_cars_type');
            $table->string('doc_cars_issuingdep');
            $table->string('doc_cars_relevantdep');
            $table->string('doc_cars_person');
            $table->string('doc_cars_topics');
            $table->string('doc_cars_defects');
            $table->string('doc_cars_problem');
            $table->BigInteger('doc_statuses_id');
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
        Schema::dropIfExists('doc_cars');
    }
};
