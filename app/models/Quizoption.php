<?php
/**
 * Created by PhpStorm.
 * User: BBarters
 * Date: 13/7/14
 * Time: 11:19 PM
 */

class Quizoption extends Eloquent
{
    protected $table='quizoptions';

    public function getQuiz()
    {
        return $this->hasMany('Quiz','quizid');
    }
} 