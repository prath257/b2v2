<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatDataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('chat_data', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('chatid')->unsigned()->default(0);
            $table->integer('senderid')->unsigned()->default(0);
            $table->binary('text',16777216);
            $table->boolean('seen')->default(0);
            $table->foreign('chatid')->references('id')->on('chats')->onDelete('cascade');
            $table->foreign('senderid')->references('id')->on('users')->onDelete('cascade');
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
		Schema::drop('chat_data');
	}

}
