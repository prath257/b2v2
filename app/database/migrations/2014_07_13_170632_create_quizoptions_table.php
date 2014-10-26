<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizoptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('quizoptions', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('quizid')->unsigned()->default(0);
            $table->foreign('quizid')->references('id')->on('quiz')->onDelete('cascade');
            $table->text('question');
            $table->string('option1',255);
            $table->string('option2',255);
            $table->string('option3',255)->nullable();
            $table->string('option4',255)->nullable();
            $table->boolean('correct1')->default(false);
            $table->boolean('correct2')->default(false);
            $table->boolean('correct3')->default(false);
            $table->boolean('correct4')->default(false);
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
		Schema::drop('quizoptions');
	}

}
