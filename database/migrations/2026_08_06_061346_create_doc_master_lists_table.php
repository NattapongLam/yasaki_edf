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
        Schema::create('doc_master_lists', function (Blueprint $table) {
            $table->id('doc_master_lists_id');
            $table->date('doc_master_lists_date');
            $table->string('doc_master_lists_type');
            $table->string('doc_master_lists_docuno');
            $table->string('doc_master_lists_docuname');
            $table->string('doc_master_lists_status');
            $table->string('doc_master_lists_department');
            $table->string('doc_master_lists_location');
            $table->json('doc_master_lists_options')->nullable();
            $table->string('doc_master_lists_file1');
            $table->string('doc_master_lists_file2');
            $table->string('doc_master_lists_note');
            $table->boolean('doc_master_lists_flag')->default(true);
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
        Schema::dropIfExists('doc_master_lists');
    }
};
