<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPlanPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plan_prices', function (Blueprint $table) {
            $table->foreign(['currency_id'], 'FK_plan_prices_currencies')->references(['id'])->on('currencies')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['plan_id'], 'FK_plan_prices_plans')->references(['id'])->on('plans')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plan_prices', function (Blueprint $table) {
            $table->dropForeign('FK_plan_prices_currencies');
            $table->dropForeign('FK_plan_prices_plans');
        });
    }
}
