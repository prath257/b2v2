<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestcontributionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('requestcontribution', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('collaboration_id')->unsigned()->default(0);
            $table->foreign('collaboration_id')->references('id')->on('collaborations')->onDelete('cascade');
            $table->text('reason');
            $table->string('link');
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
		Schema::drop('requestcontribution');
	}

}
