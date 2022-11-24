<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->unsignedInteger('product_id')->index('FK_plans_products');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('seat_max')->default(-1);
            $table->unsignedInteger('frequency_amount')->default(1);
            $table->enum('frequency_unit', ['month', 'year'])->default('month');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('is_visible')->default(true);
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
        Schema::dropIfExists('plans');
    }
}
