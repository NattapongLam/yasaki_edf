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
        Schema::create('inspection_machinery_hds', function (Blueprint $table) {
            $table->id('inspection_machinery_hds_id');
            $table->date('inspection_machinery_hds_date');
            $table->string('inspection_machinery_hds_docuno');
            $table->BigInteger('machinery_lists_id');
            $table->string('inspection_machinery_hds_vendor');
            $table->string('inspection_machinery_hds_refdocu')->nullable();
            $table->string('inspection_machinery_hds_qty');
            $table->string('inspection_machinery_hds_file')->nullable();
            $table->string('inspection_machinery_hds_remark')->nullable();
            $table->boolean('inspection_machinery_hds_flag')->default(true);
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
        Schema::dropIfExists('inspection_machinery_hds');
    }
};
