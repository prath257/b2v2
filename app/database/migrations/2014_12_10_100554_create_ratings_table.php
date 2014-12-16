<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('soccerratings', function(Blueprint $table)
		{
			$table->integer('match_id')->unsigned()->default(0);
            $table->foreign('match_id')->references('id')->on('soccerschedule')->onDelete('cascade');
            $table->integer('player_id')->unsigned()->default(0);
            $table->foreign('player_id')->references('id')->on('soccerplayer')->onDelete('cascade');
            $table->string('comment',255)->nullable();
            $table->float('rating',3,1)->unsigned()->default(0.0);
            $table->integer('user_id')->unsigned()->default(0);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
		Schema::drop('soccerratings');
	}

}
