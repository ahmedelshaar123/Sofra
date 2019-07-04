<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRestaurantsTable extends Migration {

	public function up()
	{
		Schema::create('restaurants', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->integer('district_id')->unsigned();
			$table->string('email')->unique();
			$table->string('password');
			$table->decimal('min_charge');
			$table->decimal('delivery_fees');
			$table->string('phone')->unique();
			$table->string('whatsapp')->unique();
			$table->string('image');
			$table->integer('pin_code')->nullable();
			$table->string('api_token')->unique()->nullable();
			$table->boolean('is_active')->default(0);
			$table->enum('availability', array('opened', 'closed'));


		});
	}

	public function down()
	{
		Schema::drop('restaurants');
	}
}