<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	public function up()
	{
		Schema::create('products', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->text('description');
			$table->decimal('price');
			$table->string('preparing_time');
			$table->string('image');
			$table->integer('restaurant_id')->unsigned();
			$table->boolean('disabled')->default(0);
		});
	}

	public function down()
	{
		Schema::drop('products');
	}
}