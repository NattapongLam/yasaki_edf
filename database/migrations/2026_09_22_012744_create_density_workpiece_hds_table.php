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
        Schema::create('density_workpiece_hds', function (Blueprint $table) {
            $table->id('density_workpiece_hds_id');
            $table->string('product_code');
            $table->string('product_name');
            $table->string('mlod_code');
            $table->string('mlod_name');
            $table->decimal('mlod_cavity', 18, 2)->default(0);
            $table->decimal('mlod_area', 18, 2)->default(0);
            $table->decimal('mlod_pressure', 18, 2)->default(0);
            $table->boolean('density_workpiece_hds_flag')->default(true);
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
        Schema::dropIfExists('density_workpiece_hds');
    }
};
