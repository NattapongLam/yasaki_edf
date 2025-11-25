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
        Schema::create('acc_periods', function (Blueprint $table) {
            $table->id('acc_periods_id');
            $table->string('acc_companies_year');
            $table->date('acc_companies_date1');
            $table->date('acc_companies_date2');
            $table->boolean('acc_companies_flag')->default(true);
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
        Schema::dropIfExists('acc_periods');
    }
};
