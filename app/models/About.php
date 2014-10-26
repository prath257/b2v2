<?php
/**
 * Created by PhpStorm.
 * User: kaustubh.joshi
 * Date: 6/11/14
 * Time: 7:47 PM
 */

class About extends Eloquent
{
	protected $table='about';

	//relationship

	public function aboutBy()
	{
		return $this->belongsTo('User','writtenby');
	}

} 