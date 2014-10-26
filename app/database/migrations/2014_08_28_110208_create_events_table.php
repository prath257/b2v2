<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('events', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('name',255);
            $table->string('cover',255);
            $table->binary('description',32777216)->nullable();
            $table->text('prerequesite');
            $table->text('takeaway');
            $table->integer('ifc')->unsigned()->default(0);
            $table->integer('category')->unsigned()->default(0);
            $table->foreign('category')->references('id')->on('interests')->onDelete('cascade');
            $table->string('venue',255);
            $table->datetime('datetime');
            $table->integer('users')->unsigned()->default(0);
            $table->integer('invited')->unsigned()->default(0);
            $table->boolean('open')->default(true);
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
		Schema::drop('events');
	}

}
