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
        Schema::create('ap_vendor_groups', function (Blueprint $table) {
            $table->id('ap_vendor_groups_id');
            $table->string('ap_vendor_groups_code');
            $table->string('ap_vendor_groups_name');
            $table->boolean('ap_vendor_groups_flag')->default(true);
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
        Schema::dropIfExists('ap_vendor_groups');
    }
};
