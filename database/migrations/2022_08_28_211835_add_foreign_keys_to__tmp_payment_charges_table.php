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
        Schema::table('_tmp_payment_charges', function (Blueprint $table) {
            $table->foreign("payment_service_provider_id")->references("id")->on("payment_service_providers");
            $table->foreign("customer_id")->references("id")->on("customers");
            $table->foreign("plan_price_id")->references("id")->on("plan_prices");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('_tmp_payment_charges', function (Blueprint $table) {
            //
        });
    }
};
