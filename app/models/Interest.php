<?php
/**
 * Created by PhpStorm.
 * User: kaustubh.joshi
 * Date: 5/30/14
 * Time: 2:43 PM
 */

class Interest extends Eloquent
{
	public $timestamps=false;


	//Relationships

	public function getUsers()
	{
		return $this->belongsToMany('User','user_interests');
	}

	public function getArticles()
	{
		return $this->hasMany('Article','category');
	}

    public function getBlogBooks()
    {
        return $this->hasMany('BlogBook','category');
    }

    public function getResources()
    {
        return $this->hasMany('Resource','category');
    }
} 