<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('polls', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('question',200);
            $table->string('message',140)->nullable();
            $table->boolean('ispublic')->default(true);
            $table->boolean('active')->default(true);
            $table->integer('ifc')->unsigned()->default(0);
            $table->integer('category')->unsigned()->default(0);
            $table->foreign('category')->references('id')->on('interests')->onDelete('cascade');
            $table->integer('ownerid')->unsigned()->default(0);
            $table->foreign('ownerid')->references('id')->on('users')->onDelete('cascade');
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
		Schema::drop('polls');
	}

}
