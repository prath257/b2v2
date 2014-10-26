<?php
/**
 * Created by PhpStorm.
 * User: kaustubh.joshi
 * Date: 5/28/14
 * Time: 11:53 AM
 */

class Fblogin
{

	public  static $appId = '431744100304343';
	public  static $secret = '7b2e85f3a9a67f2b1e5163e7714e64e6';
	public  static $returnurl = 'http://b2.com/b2v2/fbverify';
	public  static $permissions = 'public_profile,email';



	public static function getFburl()
	{
		$fb = new Facebook(array('appId'=>Fblogin::$appId, 'secret'=>Fblogin::$secret));
		$fbloginurl = $fb->getLoginUrl(array('redirect-uri'=>Fblogin::$returnurl, 'scope'=>Fblogin::$permissions));
		return $fbloginurl;
	}

	public static function getFbuser()
	{
		$fb = new Facebook(array('appId'=>Fblogin::$appId, 'secret'=>Fblogin::$secret));
		$fbuser = $fb->getUser();
		return $fbuser;
	}

	public static function getFb()
	{
		$fb = new Facebook(array('appId'=>Fblogin::$appId, 'secret'=>Fblogin::$secret));
		return $fb;
	}





} 