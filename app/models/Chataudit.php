<?php
/**
 * Created by PhpStorm.
 * User: ParthVaidya
 * Date: 15/6/14
 * Time: 8:35 PM
 */

class Chataudit extends Eloquent
{
    protected $table='chataudit';

    public function getUser()
    {
        return $this->belongsTo('Chataudit','userid');
    }
} 