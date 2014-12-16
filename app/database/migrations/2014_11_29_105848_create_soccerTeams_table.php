<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoccerTeamsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('soccerteam', function(Blueprint $table)
		{
			$table->increments('id');
		    $table->string('name',30);
            $table->string('logo',255);
            $table->string('stadium',50);
            $table->string('cover',255)->default('/Images/Soccer/soccer.jpeg');
            $table->string('handle',100)->nullable();
            $table->string('nickname',40)->nullable();
            $table->string('tags',255)->nullable();
            $table->integer('league')->unsigned()->default(0);
            $table->foreign('league')->references('id')->on('soccerleague')->onDelete('cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('soccerteam');
	}

}
