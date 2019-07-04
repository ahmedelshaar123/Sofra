<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactsTable extends Migration {

	public function up()
	{
		Schema::create('contacts', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('contactable_id');
			$table->string('contactable_type');
			$table->text('body');
			$table->enum('type', array('complaint', 'suggesstion', 'query'));
		});
	}

	public function down()
	{
		Schema::drop('contacts');
	}
}