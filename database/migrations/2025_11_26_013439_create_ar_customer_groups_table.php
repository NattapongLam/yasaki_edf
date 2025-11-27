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
        Schema::create('ar_customer_groups', function (Blueprint $table) {
            $table->id('ar_customer_groups_id');
            $table->string('ar_customer_groups_code');
            $table->string('ar_customer_groups_name');
            $table->boolean('ar_customer_groups_flag')->default(true);
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
        Schema::dropIfExists('ar_customer_groups');
    }
};
