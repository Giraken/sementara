<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique()->comment('Nilai sam dengan Transaction UUID');
            $table->unsignedInteger('customer_id');
            $table->unsignedBigInteger('plan_price_id');
            $table->unsignedInteger('currency_id')->index('invoices_currency_id_foreign');
            $table->string('midtrans_saved_token_id')->nullable();
            $table->dateTime('midtrans_saved_token_id_expired_at')->nullable();
            $table->string('status');
            $table->string('title');
            $table->text('description');
            $table->string('type');
            $table->longText('metadata')->nullable();
            $table->timestamps();
            $table->string('billing_first_name')->nullable();
            $table->string('billing_last_name')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_email')->nullable();
            $table->string('billing_phone')->nullable();
            $table->integer('billing_country_id')->nullable();
            $table->string('number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
