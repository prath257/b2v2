<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInviteContributorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invite_contributors', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('collaborationid')->unsigned()->default(0);
            $table->foreign('collaborationid')->references('id')->on('collaborations')->onDelete('cascade');
            $table->string('useremail',255);
            $table->string('link');
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
		Schema::drop('invite_contributors');
	}

}
