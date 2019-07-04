<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransactionsTable extends Migration {

	public function up()
	{
		Schema::create('transactions', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->decimal('amount');
			$table->text('note');
			$table->integer('restaurant_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('transactions');
	}
}