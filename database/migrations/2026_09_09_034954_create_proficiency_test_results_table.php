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
        Schema::create('proficiency_test_results', function (Blueprint $table) {
            $table->id('proficiency_test_results_id');
            $table->BigInteger('receive_test_lists_id');
            $table->integer('proficiency_test_results_no'); 
            $table->string('reportsize');
            $table->string('sizeuncertainty');
            $table->string('refvalue');
            $table->string('sizecurve1');
            $table->string('sizecurve2');
            $table->string('sizecurve3');
            $table->string('sizecurve4');
            $table->string('labuncertainty');
            $table->string('sizename');
            $table->string('ratiocurve1');
            $table->string('ratiocurve2');
            $table->string('ratiocurve3');
            $table->string('ratiocurve4');
            $table->string('evaluation');
            $table->date('proficiency_test_results_date');
            $table->string('person_at');
            $table->date('approved_date')->nullable();
            $table->string('approved_at')->nullable();
            $table->boolean('proficiency_test_results_flag')->default(true);
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
        Schema::dropIfExists('proficiency_test_results');
    }
};
