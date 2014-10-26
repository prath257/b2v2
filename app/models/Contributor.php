<?php
/**
 * Created by PhpStorm.
 * User: ParthVaidya
 * Date: 6/7/14
 * Time: 12:49 PM
 */

class Contributor extends Eloquent
{
    protected $table = 'contributors';

    public function getCollaboration()
    {
        return $this->belongsTo('Collaboration','collaborationid');
    }
} 