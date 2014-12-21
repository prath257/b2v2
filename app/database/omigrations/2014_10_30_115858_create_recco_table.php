<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReccoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recco', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('userid')->unsigned()->default(0);
            $table->text('url');
            $table->text('title');
            $table->text('description');
            $table->text('image');
            $table->integer('hits')->unsigned()->default(0);
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
		Schema::drop('recco');
	}

}
