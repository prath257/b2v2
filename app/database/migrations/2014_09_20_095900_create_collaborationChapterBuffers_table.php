<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollaborationChapterBuffersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('collaborationChapterBuffers', function(Blueprint $table)
		{
			$table->increments('id');
            $table->binary('text',32777216);
            $table->integer('chapterId');
            $table->integer('contributorId');
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
		Schema::drop('collaborationChapterBuffers');
	}

}
