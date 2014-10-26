<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('profile', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('userid')->unsigned()->default(0);
			$table->string('profilePic')->default('http://b2.com/Images/Anony.jpg');
            $table->string('coverPic')->default('http://b2.com/Images/cover.jpg');
			$table->string('profileTune')->default('http://b2.com/Audio/MI2.mp3');
			$table->string('aboutMe',255)->nullable();
			$table->integer('ifc')->unsigned()->default(0);
			$table->foreign('userid')->references('id')->on('users')->ondelete('cascade');
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
		Schema::drop('profile');
	}

}
