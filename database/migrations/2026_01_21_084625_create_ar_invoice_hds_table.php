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
        Schema::create('ar_invoice_hds', function (Blueprint $table) {
            $table->id('ar_invoice_hds_id');
            $table->date('ar_invoice_hds_date');
            $table->string('ar_invoice_hds_docuno');
            $table->integer('ar_invoice_hds_number');
            $table->BigInteger('ar_invoice_statuses_id');
            $table->BigInteger('ar_quotation_hds_id');
            $table->decimal('ar_invoice_hds_percent', 18, 2)->default(0);
            $table->decimal('ar_invoice_hds_base', 20, 4)->default(0);
            $table->decimal('ar_invoice_hds_vat', 20, 4)->default(0);
            $table->decimal('ar_invoice_hds_net', 20, 4)->default(0);
            $table->string('ar_invoice_hds_remark')->nullable();
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
        Schema::dropIfExists('ar_invoice_hds');
    }
};
