<?php
/**
 * Created by PhpStorm.
 * User: ParthVaidya
 * Date: 7/6/14
 * Time: 11:13 AM
 */

class Invite extends Eloquent
{
    protected $fillable = array('userid','name','email','link_id','activated');

    public static $invite_rules = array(
        'name' => 'required|min:2',
        'email' => 'required|email|unique:invites,email'
    );

    public static $invite_messages = array(
        'email.unique' => 'The person with this email has already been invited.'
    );

    public function invitedBy()
    {
        return $this->belongsTo('User','userid');
    }
} 