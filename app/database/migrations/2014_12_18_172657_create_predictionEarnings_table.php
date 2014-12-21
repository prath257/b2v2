<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePredictionEarningsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('predictEarnings', function(Blueprint $table)
		{
            $table->integer('id')->unsigned()->default(0);
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('ifc')->unsigned()->default(0);
            $table->integer('total')->unsigned()->default(0);
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
		Schema::drop('predictEarnings');
	}

}
