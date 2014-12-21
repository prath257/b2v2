<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('feeddata', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('feed')->unsigned()->default(0);
            $table->foreign('feed')->references('id')->on('feeds')->onDelete('cascade');
            $table->string('username',100);
            $table->text('comment');
            $table->string('snap')->nullable();
            $table->enum('type',array('pl','home','away','fan'));
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
		Schema::drop('feeddata');
	}

}
