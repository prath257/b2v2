<?php
/**
 * Created by PhpStorm.
 * User: Utkarsh
 * Date: 9/21/14
 * Time: 4:40 PM
 */



class Action extends Eloquent
{
    protected $table='actions';

    public static function postAction($type,$user1id,$user2id,$contentid,$message=null)
    {
        $action=new Action();
        $action->type=$type;
        $action->user1id=$user1id;
        if ($user2id != null)
            $action->user2id=$user2id;
        if($contentid != null)
            $action->contentid=$contentid;
        if($message!=null)
            $action->message=$message;
        $action->save();

    }
    public static function delAction($id)
    {
        Action::where('contentid','=',$id)->delete();
    }


}

