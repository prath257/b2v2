<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResourceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('resources', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title',255);
            $table->text('description');
			$table->string('path',255);
			$table->string('type',10);
			$table->integer('ifc')->unsigned()->default(0);
			$table->integer('users')->unsigned()->default(0);
			$table->integer('category')->unsigned()->default(0);
			$table->foreign('category')->references('id')->on('interests')->onDelete('cascade');
			$table->integer('userid')->unsigned()->default(0);
			$table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
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
		Schema::drop('resources');
	}

}
