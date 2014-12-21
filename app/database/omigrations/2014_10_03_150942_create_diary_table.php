<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiaryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('diary', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('userid')->unsigned()->default(0);
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
            $table->binary('text',32777216);
            $table->boolean('ispublic')->default(true);
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
		Schema::drop('diary');
	}

}
