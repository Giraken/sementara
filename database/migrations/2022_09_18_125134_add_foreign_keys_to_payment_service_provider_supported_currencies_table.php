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
        Schema::table('payment_service_provider_supported_currencies', function (Blueprint $table) {
            $table->foreign('currency_id', 'FK_PaymentServiceSupportedCurrencies_Currencies')->references('id')->on('currencies');
            $table->foreign('payment_service_provider_id', 'FK_PaymentServiceSupportedCurrencies_PaymentServices')->references('id')->on('payment_service_providers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_service_provider_supported_currencies', function (Blueprint $table) {
            //
        });
    }
};
