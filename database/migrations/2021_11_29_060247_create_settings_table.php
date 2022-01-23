<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->string('company_phone_no')->nullable();
            $table->string('company_email')->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('light_theme')->nullable();
            $table->string('dark_theme')->nullable();
            $table->string('semi_dark_theme')->nullable();
            $table->string('invoice_prefix')->nullable();
            $table->string('invoice_theme_color')->nullable();
            $table->string('termsnconditions')->nullable();
            $table->string('currency')->nullable();
            $table->integer('card_price')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
