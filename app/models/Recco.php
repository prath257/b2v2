<?php
/**
 * Created by PhpStorm.
 * User: ParthVaidya
 * Date: 30-10-2014
 * Time: 17:33
 */

class Recco extends Eloquent{

    protected $table = 'recco';

    public function user()
    {
        return $this->belongsTo('User','userid');
    }
} 