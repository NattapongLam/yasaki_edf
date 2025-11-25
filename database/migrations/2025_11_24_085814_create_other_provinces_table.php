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
        Schema::create('other_provinces', function (Blueprint $table) {
            $table->id('other_provinces_id');
            $table->unsignedBigInteger('other_countries_id');
            $table->foreign('other_countries_id')->references('other_countries_id')->on('other_countries')->onDelete('cascade');
            $table->string('other_provinces_name1');
            $table->string('other_provinces_name2')->nullable();
            $table->boolean('other_provinces_flag')->default(true);
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
        Schema::dropIfExists('other_provinces');
    }
};
