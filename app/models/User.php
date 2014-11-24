<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	protected $fillable = array('email', 'password', 'first_name','last_name','username','gender','country');

	protected $hidden = array('password');

	//Specify all the Relationships

	public function profile()
	{
		return $this->hasOne('Profile','userid');
	}


	public function interestedIn()
	{
		return $this->belongsToMany('Interest','user_interests');
	}

	public function invites()
    {
        return $this->hasMany('Invite','userid');
    }

	public function getTrivia()
	{
		return $this->hasMany('Trivia','userid');
	}

    public function getSubscribers()
    {
        return $this->belongsToMany('User', 'subscriptions', 'subscribed_to_id', 'subscriber_id');
    }

    public function getSubscribedTo()
    {
        return $this->belongsToMany('User', 'subscriptions', 'subscriber_id', 'subscribed_to_id');
    }

	public function settings()
	{
		return $this->hasOne('UserSetting','userid');
	}

	public function about()
	{
		return $this->hasMany('About','writtenfor');
	}

	public function questionsAskedToUser()
	{
		return $this->hasMany('Question','askedTo_id');
	}

    public function questionsAskedByUser()
    {
        return $this->hasMany('Question','askedBy_id');
    }

    public function getNotifications()
    {
        return $this->hasMany('Notification','userid');
    }

	public function getMedia()
	{
		return $this->hasMany('Media','userid');
	}

	public function getArticles()
	{
		return $this->hasMany('Article','userid');
	}

    public function getBlogBooks()
    {
        return $this->hasMany('BlogBook','userid');
    }

    public function getResources()
    {
        return $this->hasMany('Resource','userid');
    }

	public function readArticles()
	{
		return $this->belongsToMany('Article','articlereaders');
	}

	public function readBooks()
	{
		return $this->belongsToMany('BlogBook','bookreaders');
	}

    public function viewedMedia()
    {
        return $this->belongsToMany('Media','mediaviewers');
    }

    public function getOwnedCollaborations()
    {
        return $this->hasMany('Collaboration','userid');
    }

    public function getCollaborationChapters()
    {
        return $this->hasMany('CollaborationChapter','userid');
    }

    public function getContributions()
    {
        return $this->belongsToMany('Collaboration','contributors');
    }

    public function readCollaborations()
    {
        return $this->belongsToMany('Collaboration','collaborationreaders');
    }

    public function getPolls()
    {
        return $this->hasMany('Poll','ownerid');
    }

    public function takenQuizzes()
    {
        return $this->belongsToMany('Quiz','quiztakers');
    }

    public function getQuizes()
    {
        return $this->hasMany('Quiz','ownerid');
    }

    public function getChataudit()
    {
        return $this->hasOne('Chataudit','userid');
    }
		/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */



	public static $signup_rules = array(
		'firstname' => 'required|min:2',
		'email' => 'required|email|unique:users,email',
		'password' => 'required|min:6',
		'cpassword' => 'required|same:password',
		'country'=>'required',
		'gender'=>'required'
	);



	public static $login_rules = array('uname' => 'required','pwd' => 'required|min:6');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	//this is the function to update the users last activity
	public function updateActivity()
	{
		$this->updated_at=new Datetime();
		$this->save();
	}

    //Events
    public function getHostedEvents()
    {
        return $this->hasMany('BEvent','userid');
    }

    public function getAttendedEvents()
    {
        return $this->belongsToMany('BEvent','guest_list','user_id','event_id');
    }

    //IFC Manager
    public function getTransactions()
    {
        return $this->hasMany('Manager','userid');
    }

    public function recommendations()
    {
        return $this->hasMany('Recco','userid');
    }
}
