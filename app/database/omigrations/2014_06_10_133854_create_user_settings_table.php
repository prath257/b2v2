<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('userSettings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('userid')->unsigned()->default(0);
            $table->enum('language', array('english','spanish','hindi','marathi'));
            $table->enum('profileTheme', array('classic','standard'))->default('standard');
			$table->integer('minqifc')->unsigned()->default(50);
			$table->integer('minaboutifc')->unsigned()->default(100);
            $table->integer('friendcost')->unsigned()->default(100);
			$table->integer('subcost')->unsigned()->default(100);
			$table->integer('chatcost')->unsigned()->default(100);
            $table->boolean('notifications')->default(1);
            $table->boolean('freeforfriends')->default(0);
            $table->integer('discountforfollowers')->default(0);
            $table->enum('diaryAccess', array('public','private','semi'))->default('private');
            $table->string('diaryTitle',255);
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
		Schema::drop('userSettings');
	}

}
