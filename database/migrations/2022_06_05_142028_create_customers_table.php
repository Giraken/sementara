<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary()->comment('Nilai berasal dari tabel users kolom id');
            $table->char('uuid', 36)->comment('Pengurangan akses ke tabel users');
            $table->unsignedInteger('contact_id')->nullable();
            $table->unsignedInteger('language_id')->nullable()->index('customers_language_id_foreign');
            $table->string('timezone');
            $table->string('status')->nullable();
            $table->string('color_scheme')->nullable();
            $table->binary('quota')->nullable();
            $table->timestamps();
            $table->text('cache')->nullable();
            $table->string('text_direction')->default('ltr');
            $table->longText('payment_method')->nullable();
            $table->longText('auto_billing_data')->nullable();
            $table->string('menu_layout')->default('none');
            $table->string('theme_mode')->default('light');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
