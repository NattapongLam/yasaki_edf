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
        Schema::create('density_workcloth_hds', function (Blueprint $table) {
            $table->id('density_workcloth_hds_id');
            $table->date('density_workcloth_hds_date');
            $table->string('product_code');
            $table->string('product_name');
            $table->string('mlod_code');
            $table->string('mlod_name');
            $table->decimal('mlod_cavity', 18, 2)->default(0);
            $table->decimal('mlod_area', 18, 2)->default(0);
            $table->decimal('mlod_pressure', 18, 2)->default(0);
            $table->decimal('chemical_weight', 18, 2)->default(0);
            $table->string('chemical_temp')->nullable();
            $table->string('ms_formule_name');
            $table->string('chemistry_hd_name');
            $table->decimal('total_density', 18, 2)->default(0);
            $table->string('density_workcloth_hds_file1')->nullable();
            $table->string('density_workcloth_hds_file2')->nullable();
            $table->string('density_workcloth_hds_file3')->nullable();
            $table->string('density_workcloth_hds_file4')->nullable();
            $table->string('machinery_name')->nullable();
            $table->boolean('density_workcloth_hds_flag')->default(true);
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
        Schema::dropIfExists('density_workcloth_hds');
    }
};
