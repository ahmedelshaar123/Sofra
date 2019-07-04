<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->text('about_app');
			$table->text('conditions_and_rules');
			$table->string('facebook_url');
			$table->string('twitter_url');
			$table->string('instagram_url');
			$table->decimal('commission');
			$table->text('accounts');
		});
	}

	public function down()
	{
		Schema::drop('settings');
	}
}