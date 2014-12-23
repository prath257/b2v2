<?php

class LiveSoccerController extends \BaseController
{
    public function getLiveSoccer($fid)
    {
        $feed=Feed::find($fid);
        if($feed->live)
        {
            $mid = $feed->match_id;
            $matchDetails = SoccerSchedule::find($mid);
            $author = Auth::user();
            return View::make('soccer.liveSoccer')->with('match', $matchDetails)->with('author', $author)->with('feedId', $feed->id);
        }
        else
        {
            //here send the old feed data if you want
            $mid = $feed->match_id;
            $matchDetails = SoccerSchedule::find($mid);
            $author = Auth::user();
            return View::make('soccer.oldSoccer')->with('match', $matchDetails)->with('author', $author)->with('feedId', $feed->id);
        }
    }


    public function getLiveSoccerData()
    {
        try
        {
            $user = Auth::user();
            Auth::user()->updateSoccerActivity();
            $lastCall = new DateTime(Session::get('lastCall'));
            $feedNo = Input::get('feedNo');
            $dataFilter = Input::get('dataFilter');
            $type = intval(Input::get('type'));
            $feed = Feed::find($feedNo);
            if ($feed->live)
            {
                $feeds = new \Illuminate\Database\Eloquent\Collection();
                //if(Session::has('lastCall'))
                if ($type == -1)
                {
                    Session::put('lastCall', date('Y-m-d H:i:s'));
                    $feeds = FeedData::where('feed', $feedNo)->orderBy('created_at', 'DESC')->get();
                    return View::make('soccer.livePage')->with('feeds', $feeds);
                }
                //first check if the current admin isLive or not else make this user admin
                if ($feed->admin !== null && $feed->admin != $user->id)
                {
                    //here we need to write the code to check if admin has gone offline
                    $admin = User::find($feed->admin);
                    $currentTime = new DateTime();
                    $lastSeen = $admin->updated_at;
                    $diff = date_diff($lastSeen, $currentTime);
                    $d = intval($diff->format("%R%i"));
                    if ($d > 0) {
                        $admin->isLive = false;
                        $admin->save();
                    }
                    if ($admin->isLive == false) {
                        $feed->admin = $user->id;
                        $feed->save();
                    }
                } else {
                    $feed->admin = $user->id;
                    $feed->save();
                }
                //Now if you are admin then do all the dirty work
                if ($feed->admin == $user->id)
                {
                    $mid = $feed->match_id;
                    $matchDetails = SoccerSchedule::find($mid);
                    $currentTime = new DateTime();
                    $matchStart =  new DateTime($matchDetails->kickoff);
                    $diff = date_diff($matchStart, $currentTime);
                    $d = intval($diff->format("%R%H"));
                    if ($d > 2)
                    {
                        $feed->live=false;
                        $feed->save();
                        return 'off';
                    }
                    $homeHandle = SoccerTeam::find($matchDetails->hometeam)->handle;
                    $awayHandle = SoccerTeam::find($matchDetails->awayteam)->handle;
                    $homeTeam = SoccerTeam::find($matchDetails->hometeam)->name;
                    $awayTeam = SoccerTeam::find($matchDetails->awayteam)->name;
                    $mainHandle = 'premierleague';
                    $count = 2;
                    $include_retweets = true;
                    $exclude_replies = true;
                    $twitterfeed = array();
                    if ($type == 0) {
                        //write the code to fetch premier league tweets

                        $twitterfeed = Twitter::getUserTimeline(array('screen_name' => $mainHandle, 'count' => $count, 'include_rts' => $include_retweets, 'exclude_replies' => $exclude_replies, 'trim_user' => true));
                        if ($twitterfeed == null) {
                            return "";
                        }
                        $leagueLast = FeedData::Where('feed', $feedNo)->where('type', 'pl')->orderBy('created_at', 'DESC')->first();
                        if ($leagueLast == null) {
                            foreach ($twitterfeed as $tweet) {
                                $data = new FeedData();
                                $data->feed = $feedNo;
                                $data->username = 'EPL';
                                $data->comment = $tweet->text;
                                $data->type = 'pl';
                                if (property_exists($tweet->entities, 'media'))
                                    $data->snap = $tweet->entities->media[0]->media_url;
                                //$data->created_at = date('Y-m-d H:i:s', strtotime($tweet->created_at));
                                $data->created_at = date('Y-m-d H:i:s');
                                $data->save();
                            }

                        } else {
                            foreach ($twitterfeed as $tweet) {
                                $tweetTime = new DateTime($tweet->created_at);
                                $lastTime = $leagueLast->created_at;
                                if ($tweetTime > $lastTime) {
                                    $data = new FeedData();
                                    $data->feed = $feedNo;
                                    $data->username = 'EPL';
                                    $data->comment = $tweet->text;
                                    $data->type = 'pl';
                                    if (property_exists($tweet->entities, 'media'))
                                        $data->snap = $tweet->entities->media[0]->media_url;
                                    //$data->created_at = date('Y-m-d H:i:s', strtotime($tweet->created_at));
                                    $data->created_at = date('Y-m-d H:i:s');
                                    $data->save();
                                }
                            }

                        }


                    } else if ($type == 1) {
                        //write the code to fetch home team tweets
                        $twitterfeed = Twitter::getUserTimeline(array('screen_name' => $homeHandle, 'count' => $count, 'include_rts' => $include_retweets, 'exclude_replies' => $exclude_replies, 'trim_user' => true));
                        if ($twitterfeed == null) {
                            return "";
                        }
                        $leagueLast = FeedData::Where('feed', $feedNo)->where('type', 'home')->orderBy('created_at', 'DESC')->first();
                        if ($leagueLast == null) {
                            foreach ($twitterfeed as $tweet) {
                                $data = new FeedData();
                                $data->feed = $feedNo;
                                $data->username = $homeTeam;
                                $data->comment = $tweet->text;
                                $data->type = 'home';
                                if (property_exists($tweet->entities, 'media'))
                                    $data->snap = $tweet->entities->media[0]->media_url;
                                //$data->created_at=date('Y-m-d H:i:s',strtotime($tweet->created_at));
                                $data->created_at = date('Y-m-d H:i:s');
                                $data->save();
                            }

                        } else {
                            foreach ($twitterfeed as $tweet) {
                                $tweetTime = new DateTime($tweet->created_at);
                                $lastTime = $leagueLast->created_at;
                                if ($tweetTime > $lastTime) {
                                    $data = new FeedData();
                                    $data->feed = $feedNo;
                                    $data->username = $homeTeam;
                                    $data->comment = $tweet->text;
                                    $data->type = 'home';
                                    if (property_exists($tweet->entities, 'media'))
                                        $data->snap = $tweet->entities->media[0]->media_url;
                                    //$data->created_at = date('Y-m-d H:i:s', strtotime($tweet->created_at));
                                    $data->created_at = date('Y-m-d H:i:s');
                                    $data->save();
                                }
                            }

                        }

                    } else   //this is for type=2
                    {
                        //write the code to fetch away team tweets
                        $twitterfeed = Twitter::getUserTimeline(array('screen_name' => $awayHandle, 'count' => $count, 'include_rts' => $include_retweets, 'exclude_replies' => $exclude_replies, 'trim_user' => true));
                        if ($twitterfeed == null) {
                            return "";
                        }
                        $leagueLast = FeedData::Where('feed', $feedNo)->where('type', 'away')->orderBy('created_at', 'DESC')->first();
                        if ($leagueLast == null) {
                            foreach ($twitterfeed as $tweet) {
                                $data = new FeedData();
                                $data->feed = $feedNo;
                                $data->username = $awayTeam;
                                $data->comment = $tweet->text;
                                $data->type = 'away';
                                if (property_exists($tweet->entities, 'media'))
                                    $data->snap = $tweet->entities->media[0]->media_url;
                                //$data->created_at=date('Y-m-d H:i:s',strtotime($tweet->created_at));
                                $data->created_at = date('Y-m-d H:i:s');
                                $data->save();
                            }

                        } else {

                            foreach ($twitterfeed as $tweet) {
                                $tweetTime = new DateTime($tweet->created_at);
                                $lastTime = $leagueLast->created_at;
                                if ($tweetTime > $lastTime) {
                                    $data = new FeedData();
                                    $data->feed = $feedNo;
                                    $data->username = $awayTeam;
                                    $data->comment = $tweet->text;
                                    $data->type = 'away';
                                    if (property_exists($tweet->entities, 'media'))
                                        $data->snap = $tweet->entities->media[0]->media_url;
                                    //$data->created_at = date('Y-m-d H:i:s', strtotime($tweet->created_at));
                                    $data->created_at = date('Y-m-d H:i:s');
                                    $data->save();
                                }
                            }

                        }

                    }
                    //this is where admin duties end
                }
                //this code will execute all the time
                if ($dataFilter == 'friends') {
                    $rawFeeds = FeedData::where('feed', $feedNo)->where('created_at', '>', $lastCall)->where('type', '=', 'fan')->get();
                    foreach ($rawFeeds as $feed) {
                        $user = User::Where('username', $feed->username)->first();
                        if ($user !== null) {
                            if (Friend::isFriend($user->id)) {
                                $feeds->add($feed);
                            }
                        }

                    }
                    $neutral = FeedData::where('feed', $feedNo)->where('created_at', '>', $lastCall)->where('type', '<>', 'fan')->get();
                    foreach ($neutral as $feed) {
                        $feeds->add($feed);
                    }
                    $feeds = $feeds->sortByDesc('created_at');
                    Session::put('lastCall', date('Y-m-d H:i:s'));
                    return View::make('soccer.livePage')->with('feeds', $feeds);
                } else if ($dataFilter == 'team') {
                    $rawFeeds = FeedData::where('feed', $feedNo)->where('created_at', '>', $lastCall)->where('type', '=', 'fan')->get();
                    foreach ($rawFeeds as $feed) {
                        $user = User::Where('username', $feed->username)->first();
                        if ($user !== null) {
                            if (Auth::user()->team == $user->team) {
                                $feeds->add($feed);
                            }
                        }

                    }
                    $neutral = FeedData::where('feed', $feedNo)->where('created_at', '>', $lastCall)->where('type', '<>', 'fan')->get();
                    foreach ($neutral as $feed) {
                        $feeds->add($feed);
                    }
                    $feeds = $feeds->sortByDesc('created_at');
                    Session::put('lastCall', date('Y-m-d H:i:s'));
                    return View::make('soccer.livePage')->with('feeds', $feeds);
                } else {
                    $feeds = FeedData::where('feed', $feedNo)->where('created_at', '>', $lastCall)->orderBy('created_at', 'DESC')->get();
                    Session::put('lastCall', date('Y-m-d H:i:s'));
                    return View::make('soccer.livePage')->with('feeds', $feeds);
                }
            }
            else
            {
                return 'off';
            }
        }
        catch(Exception $e)
        {
            Mail::send('mailers', array('exception'=>$e->getMessage().' File: '.$e->getFile().' Line: '.$e->getLine(),'page'=>'exception'), function($message)
            {
                $message->to('ksjoshi88@gmail.com')->subject('Exception');
            });
            return "<h4>#soccerSpace: Connection Issue, Please reload the page.</h4>";
        }
    }


    public function saveUserComment()
    {
        try
        {
            $flag = 0;
            $usernames = array();
            $uname = '';
            $slogan = ' ';
            $feedNo = Input::get('feedNo');
            $feed = Feed::find($feedNo);
            if($feed->live) {
                $comment = Input::get('text');
                $sloganFilter = Input::get('tag');
                $dataFilter = Input::get('dataFilter');
                $feeds = new \Illuminate\Database\Eloquent\Collection();
                for ($i = 0; $i < strlen($comment); $i++) {
                    if ($flag == 1) {
                        if ($comment[$i] == ' ') {
                            $flag = 0;
                            array_push($usernames, $uname);
                            $uname = '';
                        } else
                            $uname = $uname . $comment[$i];
                    }
                    if ($comment[$i] == '~')
                        $flag = 1;

                }
                foreach ($usernames as $username) {
                    $user = User::Where('username', $username)->first();
                    $id = $user->id;
                    AjaxController::insertToNotification($id, Auth::user()->id, "tagged", "tagged you in a live soccer feed ", 'http://b2.com/liveSoccer/' . $feedNo);
                }
                $lastCall = new DateTime(Session::get('lastCall'));
                $user = Auth::user();
                if ($sloganFilter == 'true') {
                    $fanOf = SoccerTeam::find($user->team);
                    if ($fanOf != null) {
                        $slogan = $fanOf->tags;
                    }
                }
                $data = new FeedData();
                $data->feed = $feedNo;
                $data->username = $user->username;
                $data->comment = $comment . " " . $slogan;
                $data->type = 'fan';
                $data->save();
                //$feeds=FeedData::where('feed',$feedNo)->orderBy('created_at','DESC')->get();
                if ($dataFilter == 'friends') {
                    $rawFeeds = FeedData::where('feed', $feedNo)->where('created_at', '>', $lastCall)->where('type', '<>', 'fan')->get();
                    foreach ($rawFeeds as $feed) {
                        $user = User::Where('username', $feed->username)->first();
                        if ($user !== null) {
                            if (Friend::isFriend($user->id)) {
                                $feeds->add($feed);
                            }
                        }

                    }
                    $neutral = FeedData::where('feed', $feedNo)->where('created_at', '>', $lastCall)->get();
                    foreach ($neutral as $feed) {
                        $feeds->add($feed);
                    }
                    $feeds = $feeds->sortByDesc('created_at');
                    Session::put('lastCall', date('Y-m-d H:i:s'));
                    return View::make('soccer.livePage')->with('feeds', $feeds);
                } else if ($dataFilter == 'team') {
                    $rawFeeds = FeedData::where('feed', $feedNo)->where('created_at', '>', $lastCall)->where('type', '<>', 'fan')->get();
                    foreach ($rawFeeds as $feed) {
                        $user = User::Where('username', $feed->username)->first();
                        if ($user !== null) {
                            if (Auth::user()->team == $user->team) {
                                $feeds->add($feed);
                            }
                        }

                    }
                    $neutral = FeedData::where('feed', $feedNo)->where('created_at', '>', $lastCall)->get();
                    foreach ($neutral as $feed) {
                        $feeds->add($feed);
                    }
                    $feeds = $feeds->sortByDesc('created_at');
                    Session::put('lastCall', date('Y-m-d H:i:s'));
                    return View::make('soccer.livePage')->with('feeds', $feeds);
                } else {
                    $feeds = FeedData::where('feed', $feedNo)->where('created_at', '>', $lastCall)->orderBy('created_at', 'DESC')->get();
                    Session::put('lastCall', date('Y-m-d H:i:s'));
                    return View::make('soccer.livePage')->with('feeds', $feeds);
                }
                Session::put('lastCall', date('Y-m-d H:i:s'));
                return View::make('soccer.livePage')->with('feeds', $feeds);
            }
            else
            {
                return 'off';
            }
        }
        catch(Exception $e)
        {
            Mail::send('mailers', array('exception'=>$e->getMessage().' File: '.$e->getFile().' Line: '.$e->getLine(),'page'=>'exception'), function($message)
            {
                $message->to('ksjoshi88@gmail.com')->subject('Exception');
            });
            return "<h4>#soccerSpace: Connection Issue, Please reload the page.</h4>";
        }

    }

    public function searchSoccerFriends()
    {
        try {
            $flag = false;
            $foundPlayers = new \Illuminate\Database\Eloquent\Collection();
            $keywords = Input::get('name');
            $users = User::Where('id', '<>', Auth::user()->id)->get();

            foreach ($users as $player) {
                $name = $player->username;
                if (Str::contains(Str::lower($name), Str::lower($keywords))) {
                    $flag = true;
                    $foundPlayers->add($player);
                }
            }
            if ($flag == true) {

                return View::make('soccer.searchedUsers')->with('users', $foundPlayers);
            } else {
                return "";
            }
        }
        catch(Exception $e)
        {
            Mail::send('mailers', array('exception'=>$e->getMessage().' File: '.$e->getFile().' Line: '.$e->getLine(),'page'=>'exception'), function($message)
            {
                $message->to('ksjoshi88@gmail.com')->subject('Exception');
            });
            return "";
        }

    }

    //this is the  function to get the live score
    public function getLiveScore()
    {
        return View::make('soccer.liveScore');
    }

    //this function is called on applying filter
    public function getFilterData()
    {
        try
        {
            $feedNo = Input::get('feedNo');
            $feed = Feed::find($feedNo);
            if($feed->live) {
                $dataFilter = Input::get('dataFilter');
                $feeds = new \Illuminate\Database\Eloquent\Collection();
                $user = Auth::user();
                if ($dataFilter == 'friends') {
                    $rawFeeds = FeedData::where('feed', $feedNo)->where('type', '<>', 'fan')->get();
                    foreach ($rawFeeds as $feed) {
                        $user = User::Where('username', $feed->username)->first();
                        if ($user !== null) {
                            if (Friend::isFriend($user->id)) {
                                $feeds->add($feed);
                            }
                        }

                    }
                    $neutral = FeedData::where('feed', $feedNo)->get();
                    foreach ($neutral as $feed) {
                        $feeds->add($feed);
                    }
                    $feeds = $feeds->sortByDesc('created_at');
                    Session::put('lastCall', date('Y-m-d H:i:s'));
                    return View::make('soccer.livePage')->with('feeds', $feeds);
                } else if ($dataFilter == 'team') {
                    $rawFeeds = FeedData::where('feed', $feedNo)->where('type', '<>', 'fan')->get();
                    foreach ($rawFeeds as $feed) {
                        $user = User::Where('username', $feed->username)->first();
                        if ($user !== null) {
                            if (Auth::user()->team == $user->team) {
                                $feeds->add($feed);
                            }
                        }

                    }
                    $neutral = FeedData::where('feed', $feedNo)->get();
                    foreach ($neutral as $feed) {
                        $feeds->add($feed);
                    }
                    $feeds = $feeds->sortByDesc('created_at');
                    Session::put('lastCall', date('Y-m-d H:i:s'));
                    return View::make('soccer.livePage')->with('feeds', $feeds);
                } else {
                    $feeds = FeedData::where('feed', $feedNo)->orderBy('created_at', 'DESC')->get();
                    Session::put('lastCall', date('Y-m-d H:i:s'));
                    return View::make('soccer.livePage')->with('feeds', $feeds);
                }
                Session::put('lastCall', date('Y-m-d H:i:s'));
                return View::make('soccer.livePage')->with('feeds', $feeds);
            }
            else
            {
                return 'off';
            }
        }
        catch(Exception $e)
        {
            Mail::send('mailers', array('exception'=>$e->getMessage().' File: '.$e->getFile().' Line: '.$e->getLine(),'page'=>'exception'), function($message)
                {
                    $message->to('ksjoshi88@gmail.com')->subject('Exception');
                });
            $feeds = FeedData::where('feed', $feedNo)->orderBy('created_at', 'DESC')->get();
            Session::put('lastCall', date('Y-m-d H:i:s'));
            return View::make('soccer.livePage')->with('feeds', $feeds);
        }
    }

    //this is for legacy feed
    public function getOldSoccerData()
    {
        try
        {
            $user = Auth::user();
            $feedNo = Input::get('feedNo');
            $feed = Feed::find($feedNo);
            $feeds = FeedData::where('feed', $feedNo)->orderBy('created_at', 'DESC')->get();
            return View::make('soccer.livePage')->with('feeds', $feeds);
        }
        catch(Exception $e)
        {
            Mail::send('mailers', array('exception'=>$e->getMessage().' File: '.$e->getFile().' Line: '.$e->getLine(),'page'=>'exception'), function($message)
            {
                $message->to('ksjoshi88@gmail.com')->subject('Exception');
            });
            return "<h4>#soccerSpace: Connection Issue, Please reload the page.</h4>";
        }
    }

    public function getOldFilterData()
    {
        try
        {
            $feedNo = Input::get('feedNo');
            $feed = Feed::find($feedNo);
            $dataFilter = Input::get('dataFilter');
            $feeds = new \Illuminate\Database\Eloquent\Collection();
            $user = Auth::user();
                if ($dataFilter == 'friends') {
                    $rawFeeds = FeedData::where('feed', $feedNo)->where('type', '<>', 'fan')->get();
                    foreach ($rawFeeds as $feed) {
                        $user = User::Where('username', $feed->username)->first();
                        if ($user !== null) {
                            if (Friend::isFriend($user->id)) {
                                $feeds->add($feed);
                            }
                        }

                    }
                    $neutral = FeedData::where('feed', $feedNo)->get();
                    foreach ($neutral as $feed) {
                        $feeds->add($feed);
                    }
                    $feeds = $feeds->sortByDesc('created_at');
                    Session::put('lastCall', date('Y-m-d H:i:s'));
                    return View::make('soccer.livePage')->with('feeds', $feeds);
                } else if ($dataFilter == 'team') {
                    $rawFeeds = FeedData::where('feed', $feedNo)->where('type', '<>', 'fan')->get();
                    foreach ($rawFeeds as $feed) {
                        $user = User::Where('username', $feed->username)->first();
                        if ($user !== null) {
                            if (Auth::user()->team == $user->team) {
                                $feeds->add($feed);
                            }
                        }

                    }
                    $neutral = FeedData::where('feed', $feedNo)->get();
                    foreach ($neutral as $feed) {
                        $feeds->add($feed);
                    }
                    $feeds = $feeds->sortByDesc('created_at');
                    Session::put('lastCall', date('Y-m-d H:i:s'));
                    return View::make('soccer.livePage')->with('feeds', $feeds);
                } else {
                    $feeds = FeedData::where('feed', $feedNo)->orderBy('created_at', 'DESC')->get();
                    Session::put('lastCall', date('Y-m-d H:i:s'));
                    return View::make('soccer.livePage')->with('feeds', $feeds);
                }
                return View::make('soccer.livePage')->with('feeds', $feeds);

        }
        catch(Exception $e)
        {
            Mail::send('mailers', array('exception'=>$e->getMessage().' File: '.$e->getFile().' Line: '.$e->getLine(),'page'=>'exception'), function($message)
            {
                $message->to('ksjoshi88@gmail.com')->subject('Exception');
            });
            $feeds = FeedData::where('feed', $feedNo)->orderBy('created_at', 'DESC')->get();
            return View::make('soccer.livePage')->with('feeds', $feeds);
        }
    }




}
