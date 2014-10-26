<?php
/**
 * Created by PhpStorm.
 * User: Kaustubh
 * Date: 6/23/14
 * Time: 7:17 AM
 */

class Resource extends Eloquent
{
	protected $table='resources';

	//reverse relationships
	public function getAuthor()
	{
		return $this->belongsTo('User','userid');
	}


}