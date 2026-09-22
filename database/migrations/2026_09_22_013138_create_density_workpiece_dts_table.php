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
        Schema::create('density_workpiece_dts', function (Blueprint $table) {
            $table->id('density_workpiece_dts_id');
            $table->unsignedBigInteger('density_workpiece_hds_id');
            $table->foreign('density_workpiece_hds_id')->references('density_workpiece_hds_id')->on('density_workpiece_hds')->onDelete('cascade');
            $table->integer('density_workpiece_dts_listno'); 
            $table->decimal('weight_1', 18, 2)->default(0);
            $table->decimal('thickness_1', 18, 2)->default(0);
            $table->decimal('weight_2', 18, 2)->default(0);
            $table->decimal('thickness_2', 18, 2)->default(0);
            $table->decimal('weight_3', 18, 2)->default(0);
            $table->decimal('thickness_3', 18, 2)->default(0);
            $table->decimal('weight_chemical', 18, 2)->default(0);
            $table->decimal('thickness_chemical', 18, 2)->default(0);
            $table->decimal('density_workpiece_dts_volume', 20, 4)->default(0);
            $table->decimal('density_workpiece_dts_density', 20, 4)->default(0);
            $table->decimal('density_workpiece_dts_porosity', 20, 4)->default(0);
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
        Schema::dropIfExists('density_workpiece_dts');
    }
};
