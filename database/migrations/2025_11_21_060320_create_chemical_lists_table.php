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
        Schema::create('chemical_lists', function (Blueprint $table) {
            $table->id('chemical_lists_id');
            $table->unsignedBigInteger('chemical_groups_id');
            $table->foreign('chemical_groups_id')->references('chemical_groups_id')->on('chemical_groups')->onDelete('cascade');
            $table->BigInteger('chemical_funtions_id');
            $table->string('chemical_lists_name');
            $table->string('chemical_lists_grade')->nullable();
            $table->decimal('chemical_lists_density', 18, 2)->default(0);
            $table->string('chemical_lists_remark')->nullable();
            $table->string('chemical_lists_detail')->nullable();
            $table->decimal('chemical_lists_tempstart', 18, 2)->default(0);
            $table->decimal('chemical_lists_tempend', 18, 2)->default(0);
            $table->string('chemical_lists_substitute')->nullable();
            $table->string('chemical_lists_academic')->nullable();
            $table->string('chemical_lists_file1')->nullable();
            $table->string('chemical_lists_file2')->nullable();
            $table->string('chemical_lists_file3')->nullable();
            $table->string('chemical_lists_file4')->nullable();
            $table->string('chemical_lists_refcode')->nullable();
            $table->boolean('chemical_lists_flag')->default(true);
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
        Schema::dropIfExists('chemical_lists');
    }
};
