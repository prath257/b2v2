<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScorersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('soccerscorers', function(Blueprint $table)
		{
            $table->integer('match_id')->unsigned()->default(0);
            $table->foreign('match_id')->references('id')->on('soccerschedule')->onDelete('cascade');
            $table->integer('player_id')->unsigned()->default(0);
            $table->foreign('player_id')->references('id')->on('soccerplayer')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('soccerscorers');
	}

}
