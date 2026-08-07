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
        Schema::create('doc_ncrs', function (Blueprint $table) {
            $table->id('doc_ncrs_id');
            $table->date('doc_ncrs_date');
            $table->string('doc_ncrs_docuno');
            $table->string('doc_ncrs_person');
            $table->string('doc_ncrs_project');
            $table->string('doc_ncrs_to');
            $table->string('doc_ncrs_copy');
            $table->string('doc_ncrs_process');
            $table->string('doc_ncrs_product');
            $table->string('doc_ncrs_nonconformity');
            $table->BigInteger('doc_ncr_statuses_id');
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
        Schema::dropIfExists('doc_ncrs');
    }
};
