<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScorerpredictionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('soccerscorerpredictions', function(Blueprint $table)
		{
            $table->integer('match_id')->unsigned()->default(0);
            $table->foreign('match_id')->references('id')->on('soccerschedule')->onDelete('cascade');
            $table->integer('player_id')->unsigned()->default(0);
            $table->foreign('player_id')->references('id')->on('soccerplayer')->onDelete('cascade');
            $table->integer('user_id')->unsigned()->default(0);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('ifc')->unsigned()->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('soccerscorerpredictions');
	}

}
