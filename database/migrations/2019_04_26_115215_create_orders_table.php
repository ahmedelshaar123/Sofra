<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->text('notes')->nullable();
			$table->enum('state', array('pending', 'accepted', 'confirmed', 'rejected', 'delivered', 'declined'));
			$table->integer('client_id')->unsigned();
			$table->integer('restaurant_id')->unsigned();
			$table->integer('payment_method_id')->unsigned();
			$table->decimal('cost')->default(0);
			$table->decimal('delivery_fees')->default(0);
			$table->decimal('total_price')->default(0);
			$table->decimal('commission')->default(0);
			$table->decimal('net')->default(0);
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}