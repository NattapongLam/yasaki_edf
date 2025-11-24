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
        Schema::create('chemical_funtions', function (Blueprint $table) {
            $table->id('chemical_funtions_id');
            $table->unsignedBigInteger('chemical_groups_id');
            $table->foreign('chemical_groups_id')->references('chemical_groups_id')->on('chemical_groups')->onDelete('cascade');
            $table->string('chemical_funtions_name');
            $table->boolean('chemical_funtions_flag')->default(true);
            $table->string('person_at');
            $table->integer('chemical_funtions_listno');
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
        Schema::dropIfExists('chemical_funtions');
    }
};
