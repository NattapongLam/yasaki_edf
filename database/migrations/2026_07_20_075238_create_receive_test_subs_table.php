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
        Schema::create('receive_test_subs', function (Blueprint $table) {
            $table->id('receive_test_subs_id');
            $table->unsignedBigInteger('receive_test_lists_id');
            $table->foreign('receive_test_lists_id')->references('receive_test_lists_id')->on('receive_test_lists')->onDelete('cascade');
            $table->integer('receive_test_subs_listno');     
            $table->BigInteger('calibration_lists_id');
            $table->string('receive_test_subs_note')->nullable();
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
        Schema::dropIfExists('receive_test_subs');
    }
};
