<?php
/**
 * Created by PhpStorm.
 * User: BBarters
 * Date: 11/7/14
 * Time: 5:03 PM
 */

class Polloption extends Eloquent
{
    //the relationships
    public function getPoll()
    {
        return $this->belongsTo('Poll','pollid');
    }

} 