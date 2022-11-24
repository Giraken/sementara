<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('logo', 50)->nullable();
            $table->tinyInteger('is_trialable')->nullable();
            $table->text('data')->nullable();
            $table->string('domain', 50)->nullable();
            $table->enum('status', ['active', 'inactive'])->nullable();
            $table->tinyInteger('is_visible')->nullable()->default(1);
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
        Schema::dropIfExists('products');
    }
}
