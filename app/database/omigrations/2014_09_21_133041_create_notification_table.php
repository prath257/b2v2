<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notification', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('userid')->unsigned()->default(0);
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
            $table->text('type'); //eg friend request, subscription ,etc

            //friend request
            //subscription
            //question
            //about
            //chat
            //purchased
            //read
            //transfered
            //contribution


            $table->integer('cuserid')->unsigned()->default(0);
            $table->foreign('cuserid')->references('id')->on('users')->onDelete('cascade');
            $table->text('message'); // eg Riyaz 'excepted your friend request'
            $table->boolean('checked')->default(false);  //weather the notification is viewed or not
            $table->text('link'); //to send user to that page or not;
            $table->integer('chid')->unsigned()->default(0);
       //     $table->boolean('accepted')->default(false);  //for friend request
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
		Schema::drop('notification');
	}

}
