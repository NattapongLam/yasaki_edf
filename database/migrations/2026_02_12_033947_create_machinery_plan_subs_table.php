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
        Schema::create('machinery_plan_subs', function (Blueprint $table) {
            $table->id('machinery_plan_subs_id');
            $table->unsignedBigInteger('machinery_plans_id');
            $table->foreign('machinery_plans_id')->references('machinery_plans_id')->on('machinery_plans')->onDelete('cascade');
            $table->BigInteger('machinery_lists_id');
            $table->date('machinery_plan_subs_date');
            $table->integer('machinery_plan_subs_listno');   
            $table->string('machinery_plan_subs_remark');
            $table->boolean('machinery_plan_subs_flag')->default(true);
            $table->string('machinery_plan_subs_file1')->nullable();
            $table->string('machinery_plan_subs_file2')->nullable();
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
        Schema::dropIfExists('machinery_plan_subs');
    }
};
