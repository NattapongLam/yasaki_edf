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
        Schema::create('other_districts', function (Blueprint $table) {
            $table->id('other_districts_id');
            $table->unsignedBigInteger('other_provinces_id');
            $table->foreign('other_provinces_id')->references('other_provinces_id')->on('other_provinces')->onDelete('cascade');
            $table->string('other_districts_name1');
            $table->string('other_districts_name2')->nullable();
            $table->boolean('other_districts_flag')->default(true);
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
        Schema::dropIfExists('other_districts');
    }
};
