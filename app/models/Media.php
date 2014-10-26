<?php
/**
 * Created by PhpStorm.
 * User: ParthVaidya
 * Date: 20/6/14
 * Time: 8:09 PM
 */

class Media extends Eloquent
{
    protected $table='media';

	//reverse relationships
	public function getAuthor()
	{
		return $this->belongsTo('User','userid');
	}

    public function getViewers()
    {
        return $this->belongsToMany('User','mediaviewers');
    }

    public function isViewer()
    {
        $readers=DB::table('mediaviewers')->where('media_id','=',$this->id)->where('user_id','=',Auth::user()->id)->get();
        if(count($readers)>0)
            return true;
        else
            return false;
    }
}