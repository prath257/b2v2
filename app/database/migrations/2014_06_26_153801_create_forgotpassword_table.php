<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForgotpasswordTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('forgotpassword', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('username');
            $table->string('email');
            $table->string('link');
			$table->boolean('used')->default(false);

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('forgotpassword');
	}

}
