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
        Schema::create('_tmp_payment_charges', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('customer_id');
            $table->unsignedBigInteger('payment_service_provider_id');
            $table->unsignedBigInteger('plan_price_id');
            $table->string('order_id');
            $table->string('assigned_transaction_id')->nullable();
            $table->string('status');
            $table->string('price');
            $table->string('currency');
            $table->timestamps();

            $table->unique(['assigned_transaction_id', 'payment_service_provider_id'], "UQ__tmp_payment_charges_ati_pspi");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('_tmp_payment_charges');
    }
};
