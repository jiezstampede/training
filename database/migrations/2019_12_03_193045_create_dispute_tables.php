<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisputeTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number',255);
			$table->datetime('date')->nullable();
            $table->float('subtotal');
            $table->float('shipping_paid');
            $table->float('shipping_charged');
            $table->float('payment_fee');
            $table->float('total');
            $table->timestamps();
        });
        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number',255);
            $table->integer('order_id');
            $table->string('order_number',255);
            $table->string('seller_sku',255);
            $table->string('lazada_sku',255);
            $table->string('details',500);
            $table->string('shipping_provider',500);
            $table->string('delivery_status',500);
            $table->float('unit_price');
            $table->float('payment_fee');
            $table->float('shipping_paid');
            $table->float('shipping_charged');
            $table->float('promotions');
            $table->float('other_credits');
            $table->string('remarks',500);
            $table->timestamps();
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number',255);
			$table->datetime('date')->nullable();
            $table->string('type',255);
            $table->string('fee_name',255);
            $table->float('amount');
            $table->float('vat');
            $table->float('wht');
            $table->string('paid_status',255);
            $table->string('order_number',255);
            $table->string('order_item_number',255);
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
        Schema::drop('orders');
        Schema::drop('order_items');
        Schema::drop('transactions');
    }
}
