<?php
/**
 * Created by PhpStorm.
 * User: ParthVaidya
 * Date: 5/7/14
 * Time: 4:21 PM
 */

class Collaboration extends Eloquent
{
    protected $table = 'collaborations';

    public function getAdmin()
    {
        return $this->belongsTo('User','userid');
    }

    public function getChapters()
    {
        return $this->hasMany('CollaborationChapter','collaborationid');
    }

    public function getContributors()
    {
        return $this->belongsToMany('User','contributors');
    }

    public function isReader()
    {
        $readers=DB::table('collaborationreaders')->where('collaboration_id','=',$this->id)->where('user_id','=',Auth::user()->id)->get();
        if(count($readers)>0)
            return true;
        else
            return false;
    }

    public function isContributor()
    {
        $contributor = DB::table('contributors')->where('collaboration_id',$this->id)->where('user_id',Auth::user()->id)->first();

        if(count($contributor)>0)
            return true;
        else
            return false;
    }
} 