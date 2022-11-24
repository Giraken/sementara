<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->string('status');
            $table->dateTime('current_period_ends_at')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->dateTime('ends_at')->nullable();
            $table->timestamps();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('last_period_ends_at')->nullable();
            $table->unsignedInteger('customer_id')->nullable();
            $table->unsignedInteger('plan_id')->nullable()->index('subscriptions_plan_id_foreign');
            $table->unsignedInteger('currency_id')->nullable()->index('FK_subscriptions_currencies');
            $table->char('tenant_id', 128)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}
