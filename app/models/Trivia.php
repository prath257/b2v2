<?php
/**
 * Created by PhpStorm.
 * User: kaustubh.joshi
 * Date: 5/30/14
 * Time: 2:44 PM
 */

class Trivia extends Eloquent
{
	public $timestamps=false;

    protected $table='trivia';
	//Relationships
	public function represents()
	{
		return $this->belongsTo('User','userid');
	}

} 