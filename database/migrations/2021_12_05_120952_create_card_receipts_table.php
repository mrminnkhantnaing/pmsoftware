<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_receipts', function (Blueprint $table) {
            $table->id();
            $table->integer('tenant_id');
            $table->integer('card_id');
            $table->integer('card_price');
            $table->string('currency');
            $table->string('receipt_status');
            $table->date('issued_date');
            $table->date('returned_date')->nullable();
            $table->integer('from_transaction')->nullable();
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
        Schema::dropIfExists('card_receipts');
    }
}
