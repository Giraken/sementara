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
        Schema::create('paypal_registered_plans', function (Blueprint $table) {
            $table->id();
            $table->string('assigned_paypal_plan_id')->unique();
            $table->boolean('is_active')->default(false);
            $table->unsignedBigInteger('plan_price_id');
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
        Schema::dropIfExists('paypal_registered_plans');
    }
};
