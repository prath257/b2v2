<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('questions', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('askedBy_id')->unsigned()->default(0);
            $table->integer('askedTo_id')->unsigned()->default(0);
            $table->text('question');
            $table->binary('description',32777216)->nullable();
            $table->binary('answer',32777216);
            $table->integer('ifc');
            $table->boolean('private')->default(false);
            $table->foreign('askedBy_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('askedTo_id')->references('id')->on('users')->onDelete('cascade');
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
		Schema::drop('questions');
	}

}
