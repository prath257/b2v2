<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePolloptionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('polloptions', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('option');
            $table->integer('pollid')->unsigned()->default(0);
            $table->foreign('pollid')->references('id')->on('polls')->onDelete('cascade');
            $table->integer('responses')->unsigned()->default(0);
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
		Schema::drop('polloptions');
	}

}
