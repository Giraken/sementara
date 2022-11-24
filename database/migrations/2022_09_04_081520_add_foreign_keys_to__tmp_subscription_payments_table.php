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
        Schema::table('_tmp_subscription_payments', function (Blueprint $table) {
            $table->foreign('plan_id')->on('plans')->references('id')->onDelete('RESTRICT');
            $table->foreign('customer_id')->on('customers')->references('id')->onDelete('RESTRICT');
            $table->foreign('payment_service_provider_id')->on('payment_service_providers')->references('id')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('_tmp_subscription_payments', function (Blueprint $table) {
            //
        });
    }
};
