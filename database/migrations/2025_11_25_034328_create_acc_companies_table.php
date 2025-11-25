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
        Schema::create('acc_companies', function (Blueprint $table) {
            $table->id('acc_companies_id');
            $table->string('acc_companies_name1');
            $table->string('acc_companies_name2')->nullable();
            $table->string('acc_companies_address1');
            $table->string('acc_companies_address2')->nullable();
            $table->string('acc_companies_taxid');
            $table->string('acc_companies_tel');
            $table->string('acc_companies_email');
            $table->string('acc_companies_line')->nullable();
            $table->string('acc_companies_website')->nullable();
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
        Schema::dropIfExists('acc_companies');
    }
};
