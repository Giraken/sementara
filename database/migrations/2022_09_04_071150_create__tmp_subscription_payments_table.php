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
        Schema::create('_tmp_subscription_payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('plan_id');
            $table->unsignedInteger('customer_id');
            $table->unsignedBigInteger('payment_service_provider_id');

            $table->string('assigned_subscription_id');
            $table->string('status');
            $table->json('metadata')->nullable();

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
        Schema::dropIfExists('_tmp_subscription_payments');
    }
};
