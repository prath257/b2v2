<?php

class SettingsController extends \BaseController
{
    public function saveAccountSettings()
    {
        if(Auth::check())
        {
        $settings = Auth::user()->settings;
        $settings->profileTheme = Input::get('profileTheme');
        $settings->minqifc = Input::get('minqifc');
        $settings->minaboutifc = Input::get('minaboutifc');
        $settings->friendcost = Input::get('friendcost');
        $settings->subcost = Input::get('subcost');
        $settings->chatcost = Input::get('chatcost');
        $settings->notifications = Input::get('notifications');
        $settings->freeforfriends = Input::get('freeforfriends');
        $settings->discountforfollowers = Input::get('discountforfollowers');
        $settings->save();

        return "Saved!";
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function resetPassword()
    {
        if(Auth::check())
        {
        $userabc = Auth::user();
        $credentials = array('username' => Auth::user()->username,'password' => Input::get('existingPassword'));

        Auth::logout();

        Auth::attempt($credentials);
        if (Auth::check())
        {
            $user = Auth::user();
            $user->password = Hash::make(Input::get('newPassword'));
            $user->save();

            return "Saved";
        }

        Auth::login($userabc);

        return "Sorry, 'Existing Password' is wrong";
    }
        else
            return 'wH@tS!nTheB0x';
    }
}
