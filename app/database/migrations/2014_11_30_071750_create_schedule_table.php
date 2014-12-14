<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('soccerschedule', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('league')->unsigned()->default(0);
            $table->foreign('league')->references('id')->on('soccerleague')->onDelete('cascade');
            $table->integer('matchday')->unsigned();
            $table->integer('hometeam')->unsigned()->default(0);
            $table->foreign('hometeam')->references('id')->on('soccerteam')->onDelete('cascade');
            $table->integer('awayteam')->unsigned()->default(0);
            $table->foreign('awayteam')->references('id')->on('soccerteam')->onDelete('cascade');
            $table->dateTime('kickoff');
            $table->integer('hgoals')->unsigned()->nullable();
            $table->integer('agoals')->unsigned()->nullable();
           });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('soccerschedule');
	}

}
