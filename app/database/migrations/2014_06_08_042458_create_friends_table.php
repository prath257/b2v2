<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('friends', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('friend1')->unsigned()->default(0);
			$table->integer('friend2')->unsigned()->default(0);
			$table->enum('status',array('sent','pending','accepted'));
            $table->text('reason')->nullable();
			$table->foreign('friend1')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('friend2')->references('id')->on('users')->onDelete('cascade');
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
		Schema::drop('friends');
	}

}
