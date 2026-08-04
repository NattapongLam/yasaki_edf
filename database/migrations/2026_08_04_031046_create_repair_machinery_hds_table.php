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
        Schema::create('repair_machinery_hds', function (Blueprint $table) {
            $table->id('repair_machinery_hds_id');
            $table->date('repair_machinery_hds_date');
            $table->string('repair_machinery_hds_docuno');
            $table->integer('repair_machinery_hds_number');
            $table->string('repair_machinery_hds_type');
            $table->date('repair_machinery_hds_duedate');
            $table->BigInteger('repair_id');
            $table->string('repair_code');
            $table->string('repair_name');
            $table->BigInteger('repair_machinery_statuses_id');
            $table->string('repair_machinery_hds_remark')->nullable();
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
        Schema::dropIfExists('repair_machinery_hds');
    }
};
