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
        Schema::create('machinery_plans', function (Blueprint $table) {
            $table->id('machinery_plans_id');
            $table->date('machinery_plans_date');
            $table->BigInteger('machinery_lists_id');
            $table->string('machinery_lists_code');
            $table->string('machinery_lists_name');
            $table->date('machinery_plans_resultdate')->nullable();
            $table->boolean('machinery_plans_plan')->default(true);
            $table->boolean('machinery_plans_action')->default(false);
            $table->string('machinery_plans_remark')->nullable();
            $table->string('person_at');
            $table->string('machinery_plans_file1')->nullable();
            $table->string('machinery_plans_file2')->nullable();
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
        Schema::dropIfExists('machinery_plans');
    }
};
