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
        Schema::create('machinery_checksheet_hds', function (Blueprint $table) {
            $table->id('machinery_checksheet_hds_id');
            $table->date('machinery_checksheet_hds_date');
            $table->BigInteger('machinery_lists_id');
            $table->string('machinery_lists_code');
            $table->string('machinery_lists_name');
            $table->string('machinery_checksheet_hds_remark')->nullable();
            $table->boolean('machinery_checksheet_hds_flag')->default(true);
            $table->string('person_at');
            $table->date('approved_date')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('approved_remark')->nullable();
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
        Schema::dropIfExists('machinery_checksheet_hds');
    }
};
