<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('image')->nullable();
			$table->string('email')->unique();
			$table->string('phone')->unique();
			$table->integer('district_id')->unsigned();
			$table->text('description');
			$table->string('password');
			$table->boolean('is_active')->default(1);
			$table->integer('pin_code')->nullable();
			$table->string('api_token')->unique()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('clients');
	}
}