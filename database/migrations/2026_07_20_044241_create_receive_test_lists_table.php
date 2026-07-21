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
        Schema::create('receive_test_lists', function (Blueprint $table) {
            $table->id('receive_test_lists_id');
            $table->unsignedBigInteger('ar_requestorder_hds_id');
            $table->foreign('ar_requestorder_hds_id')->references('ar_requestorder_hds_id')->on('ar_requestorder_hds')->onDelete('cascade');
            $table->date('receive_test_lists_date');
            $table->string('receive_test_lists_file1')->nullable();
            $table->string('receive_test_lists_file2')->nullable();
            $table->string('receive_test_lists_file3')->nullable();
            $table->string('receive_test_lists_dimensions');
            $table->BigInteger('dimensions_id');
            $table->string('receive_test_lists_weight');
            $table->BigInteger('weight_id');
            $table->BigInteger('chemistry_hd_id');
            $table->string('receive_test_lists_note')->nullable();
            $table->string('person_at');
            $table->boolean('receive_test_lists_flag')->default(true);
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
        Schema::dropIfExists('receive_test_lists');
    }
};
