<?php
/**
 * Created by PhpStorm.
 * User: ParthVaidya
 * Date: 5/7/14
 * Time: 5:07 PM
 */

class CollaborationChapter extends Eloquent
{
    protected $table = 'collaboration_chapters';

    public function getCollaboration()
    {
        return $this->belongsTo('Collaboration','collaborationid');
    }

    public function getWriter()
    {
        return $this->belongsTo('User','userid');
    }
} 