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
        Schema::create('acc_currencies', function (Blueprint $table) {
            $table->id('acc_currencies_id');
            $table->string('acc_currencies_code');
            $table->string('acc_currencies_name');
            $table->decimal('acc_currencies_rate', 18, 2)->default(0);
            $table->boolean('acc_currencies_flag')->default(true);
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
        Schema::dropIfExists('acc_currencies');
    }
};
