<?php
/**
 * Created by PhpStorm.
 * User: ParthVaidya
 * Date: 23/6/14
 * Time: 7:33 PM
 */

class BlogBook extends Eloquent
{
    protected $table = 'blogbooks';

    public function getAuthor()
    {
        return $this->belongsTo('User','userid');
    }

    public function getCategory()
    {
        return $this->belongsTo('Interest','category');
    }

    public function getChapters()
    {
        return $this->hasMany('Chapter','bookid');
    }

	public function getReaders()
	{
		return $this->belongsToMany('User','bookreaders');
	}

	public function isReader()
	{
		$readers=DB::table('bookreaders')->where('blog_book_id','=',$this->id)->where('user_id','=',Auth::user()->id)->get();
		if(count($readers)>0)
			return true;
		else
			return false;
	}

} 