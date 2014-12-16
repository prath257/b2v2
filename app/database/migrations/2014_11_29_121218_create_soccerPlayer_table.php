<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoccerPlayerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('soccerplayer', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('first_name',30);
            $table->string('last_name',30)->nullable();
            $table->string('position',20);
            $table->string('picture',150)->default('/Images/Anony.jpg');
            $table->integer('team')->unsigned()->default(0);
            $table->foreign('team')->references('id')->on('soccerteam')->onDelete('cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('soccerplayer');
	}

}
