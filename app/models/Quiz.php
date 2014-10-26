<?php
/**
 * Created by PhpStorm.
 * User: BBarters
 * Date: 13/7/14
 * Time: 11:19 PM
 */

class Quiz extends Eloquent
{
    protected $table='quiz';

    //relationship
    public function getOptions()
    {
        return $this->hasMany('Quizoption','quizid');
    }

    public function getTakers()
    {
        return $this->belongsToMany('User','quiztakers');
    }
} 