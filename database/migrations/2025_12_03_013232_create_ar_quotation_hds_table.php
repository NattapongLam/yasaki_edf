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
        Schema::create('ar_quotation_hds', function (Blueprint $table) {
            $table->id('ar_quotation_hds_id');
            $table->date('ar_quotation_hds_date');
            $table->string('ar_quotation_hds_docuno');
            $table->integer('ar_quotation_hds_number');
            $table->BigInteger('ar_quotation_statuses_id');
            $table->BigInteger('ar_customer_lists_id');
            $table->string('ar_customer_lists_code');
            $table->string('ar_customer_lists_name');
            $table->string('ar_customer_lists_address');
            $table->string('ar_customer_lists_taxid')->nullable();
            $table->string('ar_customer_lists_contact')->nullable();
            $table->string('ar_customer_lists_tel');
            $table->string('ar_customer_lists_email')->nullable();
            $table->integer('ar_customer_lists_credit');
            $table->BigInteger('acc_typevats_id');
            $table->BigInteger('acc_currencies_id');
            $table->BigInteger('acc_discount_id');
            $table->decimal('acc_discount_qty', 18, 2)->default(0);
            $table->string('ar_quotation_hds_remark')->nullable();
            $table->decimal('ar_quotation_hds_base', 20, 4)->default(0);
            $table->decimal('ar_quotation_hds_vat', 20, 4)->default(0);
            $table->decimal('ar_quotation_hds_net', 20, 4)->default(0);
            $table->decimal('ar_quotation_hds_dis', 20, 4)->default(0);
            $table->decimal('ar_quotation_hds_amount', 20, 4)->default(0);
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
        Schema::dropIfExists('ar_quotation_hds');
    }
};
