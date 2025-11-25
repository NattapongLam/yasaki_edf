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
        Schema::create('acc_typevats', function (Blueprint $table) {
            $table->id('acc_typevats_id');
            $table->string('acc_typevats_code');
            $table->decimal('acc_typevats_rate', 18, 2)->default(0);
            $table->boolean('acc_typevats_flag')->default(true);
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
        Schema::dropIfExists('acc_typevats');
    }
};
