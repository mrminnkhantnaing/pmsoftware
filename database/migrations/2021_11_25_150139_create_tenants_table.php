<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // $table->string('idorpassport')->unique();
            $table->string('idorpassport')->nullable();
            $table->string('whatsapp_no')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('email')->nullable();
            $table->string('gender')->nullable();
            $table->string('country_id')->nullable();
            $table->integer('status')->nullable();
            $table->date('joined_date')->nullable();
            $table->integer('fixed_deposit')->nullable();
            $table->integer('previous_balance')->nullable();
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
        Schema::dropIfExists('tenants');
    }
}
