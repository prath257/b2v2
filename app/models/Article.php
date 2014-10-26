<?php
/**
 * Created by PhpStorm.
 * User: Kaustubh
 * Date: 6/21/14
 * Time: 11:38 AM
 */

class Article extends Eloquent
{
	protected $table='articles';


	//relationships

	public function getAuthor()
	{
		return $this->belongsTo('User','userid');
	}

	public function getCategory()
	{
		return $this->belongsTo('Interest','category');
	}
	public function getReaders()
	{
		return $this->belongsToMany('User','articlereaders');
	}

	public function isReader()
	{
		$readers=DB::table('articlereaders')->where('article_id','=',$this->id)->where('user_id','=',Auth::user()->id)->get();
		if(count($readers)>0)
			return true;
		else
			return false;
	}
}