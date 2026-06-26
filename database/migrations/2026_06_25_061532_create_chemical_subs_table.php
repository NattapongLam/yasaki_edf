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
        Schema::create('chemical_subs', function (Blueprint $table) {
            $table->id('chemical_subs_id');
            $table->unsignedBigInteger('chemical_lists_id');
            $table->foreign('chemical_lists_id')->references('chemical_lists_id')->on('chemical_lists')->onDelete('cascade');
            $table->integer('chemical_subs_listno');  
            $table->string('chemical_subs_name');
            $table->string('chemical_subs_casno')->nullable();
            $table->string('chemical_subs_ecno')->nullable();
            $table->string('chemical_subs_qty')->nullable();
            $table->boolean('chemical_subs_flag')->default(true);
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
        Schema::dropIfExists('chemical_subs');
    }
};
