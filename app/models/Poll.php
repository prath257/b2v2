<?php
/**
 * Created by PhpStorm.
 * User: BBarters
 * Date: 11/7/14
 * Time: 5:03 PM
 */

class Poll extends Eloquent
{
    protected $table='polls';

    //the relationships
    public function getOptions()
    {
        return $this->hasMany('Polloption','pollid');
    }

} 