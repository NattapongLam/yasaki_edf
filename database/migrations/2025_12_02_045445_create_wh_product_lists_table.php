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
        Schema::create('wh_product_lists', function (Blueprint $table) {
            $table->id('wh_product_lists_id');
            $table->unsignedBigInteger('wh_product_types_id');
            $table->foreign('wh_product_types_id')->references('wh_product_types_id')->on('wh_product_types')->onDelete('cascade');
            $table->unsignedBigInteger('wh_product_groups_id');
            $table->foreign('wh_product_groups_id')->references('wh_product_groups_id')->on('wh_product_groups')->onDelete('cascade');
            $table->unsignedBigInteger('wh_product_units_id');
            $table->foreign('wh_product_units_id')->references('wh_product_units_id')->on('wh_product_units')->onDelete('cascade');
            $table->string('wh_product_lists_code');
            $table->string('wh_product_lists_name1');
            $table->string('wh_product_lists_name2')->nullable();
            $table->string('wh_product_lists_remark')->nullable();
            $table->decimal('wh_product_lists_cost', 18, 2)->default(0);
            $table->decimal('wh_product_lists_price', 18, 2)->default(0);
            $table->decimal('wh_product_lists_min', 18, 2)->default(0);
            $table->decimal('wh_product_lists_max', 18, 2)->default(0);
            $table->decimal('wh_product_lists_moq', 18, 2)->default(0);
            $table->decimal('wh_product_lists_timeline', 18, 2)->default(0);
            $table->string('wh_product_lists_file1')->nullable();
            $table->string('wh_product_lists_file2')->nullable();
            $table->string('wh_product_lists_file3')->nullable();
            $table->string('wh_product_lists_file4')->nullable();
            $table->boolean('wh_product_lists_flag')->default(true);
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
        Schema::dropIfExists('wh_product_lists');
    }
};
