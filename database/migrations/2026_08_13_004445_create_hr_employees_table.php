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
        Schema::create('hr_employees', function (Blueprint $table) {
            $table->id('hr_employees_id');
            $table->string('hr_employees_code');
            $table->string('hr_employees_fullname');
            $table->string('hr_employees_department');
            $table->string('hr_employees_position');
            $table->string('hr_employees_taxid');
            $table->string('hr_employees_institution');
            $table->string('hr_employees_educationa');
            $table->string('hr_employees_branch');
            $table->string('hr_employees_address');
            $table->boolean('hr_employees_flag')->default(true);
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
        Schema::dropIfExists('hr_employees');
    }
};
