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
        Schema::create('density_workcloth_dts', function (Blueprint $table) {
            $table->id('density_workcloth_dts_id');
            $table->unsignedBigInteger('density_workcloth_hds_id');
            $table->foreign('density_workcloth_hds_id')->references('density_workcloth_hds_id')->on('density_workcloth_hds')->onDelete('cascade');
            $table->integer('density_workcloth_dts_listno'); 
            $table->decimal('weight_1', 18, 2)->default(0);
            $table->decimal('thickness_1', 18, 2)->default(0);
            $table->decimal('thickness_2', 18, 2)->default(0);
            $table->decimal('thickness_3', 18, 2)->default(0);
            $table->decimal('thickness_4', 18, 2)->default(0);
            $table->decimal('thickness_5', 18, 2)->default(0);
            $table->decimal('thickness_6', 18, 2)->default(0);
            $table->decimal('thickness_chemical', 18, 2)->default(0);
            $table->decimal('volume', 20, 4)->default(0);
            $table->decimal('density', 20, 4)->default(0);
            $table->decimal('porosity', 20, 4)->default(0);
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
        Schema::dropIfExists('density_workcloth_dts');
    }
};
