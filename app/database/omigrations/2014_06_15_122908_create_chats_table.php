<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('chats', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('user1')->unsigned()->default(0);
            $table->integer('user2')->unsigned()->default(0);
            $table->string('reason',140);
            $table->string('link_id',10);
            $table->enum('status',array('pending','ongoing','completed'));
            $table->boolean('user1IsTyping')->default(0);
            $table->boolean('user2IsTyping')->default(0);
            $table->boolean('justclosed')->default(false);
            $table->foreign('user1')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user2')->references('id')->on('users')->onDelete('cascade');
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
		Schema::drop('chats');
	}

}
