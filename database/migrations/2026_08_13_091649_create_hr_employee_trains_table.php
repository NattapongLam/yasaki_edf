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
        Schema::create('hr_employee_trains', function (Blueprint $table) {
            $table->id('hr_employee_trains_id');
            $table->unsignedBigInteger('hr_employees_id');
            $table->foreign('hr_employees_id')->references('hr_employees_id')->on('hr_employees')->onDelete('cascade');
            $table->integer('hr_employee_trains_listno');  
            $table->date('hr_employee_trains_date');
            $table->string('hr_employee_trains_remark');
            $table->string('hr_employee_trains_file');
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
        Schema::dropIfExists('hr_employee_trains');
    }
};
