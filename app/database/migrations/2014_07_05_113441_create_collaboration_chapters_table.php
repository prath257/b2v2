<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollaborationChaptersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('collaboration_chapters', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('title',255);
            $table->binary('text',32777216);
            $table->integer('collaborationid')->unsigned()->default(0);
            $table->foreign('collaborationid')->references('id')->on('collaborations')->onDelete('cascade');
            $table->integer('userid')->unsigned()->default(0);
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('approved')->default(0);
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
		Schema::drop('collaboration_chapters');
	}

}
