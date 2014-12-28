<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('username',30)->unique();
			$table->string('password');
			$table->string('first_name',30);
			$table->string('last_name',30)->nullable();
			$table->string('email')->unique();
			$table->enum('gender',array('male','female','other'));
			$table->string('country',30);
			$table->boolean('activated')->default(false);
            $table->boolean('isOnline')->default(false);
			$table->string('remember_token',255);
			$table->string('fbid',255)->nullable();
            $table->string('gid',255)->nullable();
            $table->bigInteger('twitterid')->unsigned()->nullable();
			$table->boolean('pset')->default(false);
            $table->integer('team')->unsigned()->default(0);
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
		Schema::drop('users');
	}

}
