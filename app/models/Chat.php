<?php
/**
 * Created by PhpStorm.
 * User: ParthVaidya
 * Date: 15/6/14
 * Time: 8:35 PM
 */

class Chat extends Eloquent
{
    protected $table='chats';

    public function getChatData()
    {
        return $this->hasMany('ChatData','chatid');
    }
} 