<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_balances', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id');
            $table->string('invoice_status')->nullable();
            $table->string('invoice_type')->nullable();
            $table->integer('no_of_tenant')->nullable();
            $table->integer('tenant_id')->nullable();
            $table->integer('building_id')->nullable();
            $table->integer('floor_id')->nullable();
            $table->integer('flat_id')->nullable();
            $table->integer('partition_id')->nullable();
            $table->integer('card_id')->nullable();
            $table->integer('card_price')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('price')->nullable();
            $table->string('currency')->nullable();
            $table->integer('sub_total')->nullable();
            $table->integer('total_price')->nullable();
            $table->integer('initial_payment_amount')->nullable();
            $table->integer('current_payment_amount')->nullable();
            $table->integer('balance')->nullable();
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
        Schema::dropIfExists('pay_balances');
    }
}
