<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_no')->unique();
            $table->string('invoice_prefix');
            $table->string('invoice_status');
            $table->string('invoice_type');
            $table->integer('tenant_id');
            $table->integer('building_id');
            $table->integer('floor_id');
            $table->integer('flat_id');
            $table->integer('partition_id');
            $table->integer('no_of_tenant');
            $table->integer('card_id')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('price');
            $table->integer('card_price')->nullable();
            $table->string('currency')->nullable();
            $table->integer('sub_total');
            $table->integer('total_price');
            $table->date('reservation_date')->nullable();
            $table->integer('deposit')->nullable();
            $table->integer('payment_amount')->nullable();
            $table->date('rest_payment_date')->nullable();
            $table->integer('balance')->nullable(); // balance of the invoice
            $table->integer('referrer_id')->nullable();
            $table->boolean('notice')->default(0); // change notice status when tenant gives notice
            $table->boolean('moved')->default(0); // change moved status when tenant moves
            $table->boolean('paid_balance')->default(0); // change paid balance status when the paybalance's balance is zero
            $table->integer('fixed_deposit')->default(0); // fixed balance that stands alone in tenants table
            $table->integer('previous_balance')->default(0); // previous balance that stands alone in tenants table
            $table->boolean('created_another_invoice')->default(0); // control dued invoice when created new invoice
            $table->boolean('reservation_activated')->default(0); // control if reservation is stayed or not
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
        Schema::dropIfExists('transactions');
    }
}
