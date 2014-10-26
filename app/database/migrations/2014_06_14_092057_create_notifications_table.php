<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notifications', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('userid')->unsigned()->default(0);
            $table->integer('nid')->unsigned()->default(0);
            $table->enum('ntype',array('frequest','faccepted','chatrequest','chataccepted','aboutrequest','aboutaccepted','qasked','qanswered','subscription'));
            $table->boolean('checked')->default(0);
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
		Schema::drop('notifications');
	}

}
