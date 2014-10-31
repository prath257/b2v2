<?php
/**
 * Created by PhpStorm.
 * User: kaustubh.joshi
 * Date: 5/30/14
 * Time: 2:43 PM
 */

class Profile extends Eloquent
{


    protected $table='newprofile';

	//Relationships

	public function ofUser()
	{
		return $this->belongsTo('User','userid');
	}
} 