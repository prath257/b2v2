<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagerTable extends Migration {


	public function up()
	{
		Schema::create('manager', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('userid')->unsigned()->default(0);
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
            $table->string('ifc',20);
            $table->integer('ifctotal')->unsigned();
            $table->text('message');
            $table->string('link',200)->default('nope');  // reference to the article or the profile if required
            $table->string('type');     //profile or content
            $table->string('linkname');
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
		Schema::drop('manager');
	}

}
