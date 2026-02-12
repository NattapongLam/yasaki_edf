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
        Schema::create('machinery_lists', function (Blueprint $table) {
            $table->id('machinery_lists_id');
            $table->unsignedBigInteger('machinery_groups_id');
            $table->foreign('machinery_groups_id')->references('machinery_groups_id')->on('machinery_groups')->onDelete('cascade');
            $table->string('machinery_lists_code');
            $table->string('machinery_lists_name1');
            $table->string('machinery_lists_name2')->nullable();
            $table->date('machinery_lists_date')->nullable();
            $table->date('machinery_lists_expirationdate')->nullable();
            $table->string('machinery_lists_brand')->nullable();
            $table->string('machinery_lists_serialno')->nullable();
            $table->string('machinery_lists_location')->nullable();
            $table->string('machinery_lists_reamrk')->nullable();
            $table->string('machinery_lists_file1')->nullable();
            $table->string('machinery_lists_file2')->nullable();
            $table->string('machinery_lists_file3')->nullable();
            $table->string('machinery_lists_file4')->nullable();
            $table->boolean('machinery_lists_flag')->default(true);
            $table->date('machinery_lists_plandate')->nullable();
            $table->date('machinery_lists_nextdate')->nullable();
            $table->integer('machinery_lists_day')->nullable();
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
        Schema::dropIfExists('machinery_lists');
    }
};
