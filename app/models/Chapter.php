<?php
/**
 * Created by PhpStorm.
 * User: ParthVaidya
 * Date: 23/6/14
 * Time: 9:23 PM
 */

class Chapter extends Eloquent
{
    protected $table = 'chapters';

    public function writtenIn()
    {
        return $this->belongsTo('BlogBook','bookid');
    }
} 