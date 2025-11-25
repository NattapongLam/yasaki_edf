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
        Schema::create('other_sub_districts', function (Blueprint $table) {
            $table->id('other_sub_districts_id');
            $table->unsignedBigInteger('other_districts_id');
            $table->foreign('other_districts_id')->references('other_districts_id')->on('other_districts')->onDelete('cascade');
            $table->string('other_sub_districts_name1');
            $table->string('other_sub_districts_name2')->nullable();
            $table->string('other_sub_districts_zipcode')->nullable();
            $table->boolean('other_sub_districts_flag')->default(true);
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
        Schema::dropIfExists('other_sub_districts');
    }
};
