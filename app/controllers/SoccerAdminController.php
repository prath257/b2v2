<?php

class SoccerAdminController extends \BaseController
{

    public function getPlayers()
    {
        for($i=1;$i<=633;$i++)
        {
            $url = 'http://fantasy.premierleague.com/web/api/elements/'.$i;
            libxml_use_internal_errors(true);
            $player = json_decode(file_get_contents($url));
            $pieces = explode(".", $player->photo);
            $pn=$pieces[0];
            // if(count($player->first_name)>1)
            //  {
            $alpha = strtolower($player->first_name)[0];
            $fn = strtolower($player->first_name);
            //   }
            //   else
            //  {
            //       $alpha = 'a';
            //        $fn = " ";
            //     }
            $ln=strtolower($player->second_name);
            $picUrl='http://www.premierleague.com/content/dam/premierleague/shared-images/players/'.$alpha.'/'.$fn.'-'.$ln.'/'.$pn.'-lsh.jpg';
            $sp=new SoccerPlayer();
            $sp->first_name=$player->first_name;
            $sp->last_name=$player->second_name;
            $sp->position=$player->type_name;
            $sp->team_name=$player->team_name;
            try
            {
                if (getimagesize($picUrl) !== false)
                {
                    $sp->picture = $picUrl;

                }
                $sp->save();
            }
            catch(exception $e)
            {
                $sp->save();
            }
        }
        return "All Players are in the PARK!";
    }



    //this is the function which gives eplfixtures
    public static function getFixtures($lid=1)
    {
        $html=null;
        $url = 'http://www.bbc.com/sport/football/premier-league/fixtures';
        libxml_use_internal_errors(true);
        $page_content = file_get_contents($url);
        if($page_content != null)
        {
            $dom_obj = new DOMDocument();
            $dom_obj->loadHTML($page_content);

            $fixDiv = $dom_obj->getElementById('fixtures-data');
            //$title=$fixDiv->nodeValue;
            $html = '';
            foreach ($fixDiv->childNodes as $node)
            {
                    $myvar=$node;
                    $html .= $dom_obj->saveHTML($node);

            }
        }
        return $html;
    }

       //These are the real routes
    public function getAdminPage()
    {
        return View::make('soccer.admin');
    }

    public function createSchedule()
    {
        $type=Input::get('type');
        $leagues=SoccerLeague::All();
        return View::make('soccer.newSchedule')->with('leagues',$leagues)->with('type',$type);
    }

    public function getNextMatchDay()
    {
        $lid=Input::get('league');
        $type=Input::get('type');
        $league=SoccerLeague::find($lid);
        if($type=='predict')
        {
            $match=SoccerSchedule::Where('league','=',$lid)->where('hgoals','=',null)->first();
            if($match==null)
            {
                return 'NoMatch';
            }
            else
            {
                $matchDay = $match->matchday;
                return View::make('soccer.matchdayInfo')->with('matchday', $matchDay)->with('league', $league)->with('type',null);
            }

        }
        else if($type=='friends')
        {
            $match=SoccerSchedule::Where('league','=',$lid)->where('hgoals','=',null)->first();
            if($match==null)
            {
                return 'NoMatch';
            }
            else
            {
                $matchDay = $match->matchday;
                $matches=SoccerSchedule::Where('league',$lid)->where('matchday',$matchDay)->get();
                return View::make('soccer.matchdayInfo')->with('matchday', $matchDay)->with('league', $league)->with('type', $type)->with('matches',$matches);
            }
        }
        else if($type=='newratings')
        {
            $matchDay = DB::table('soccerschedule')->where('league', '=', $lid)->whereNotNull('hgoals')->max('matchday');
            if($matchDay==null)
            {
                return 'NoResult';
            }
            else
            {
                $matches=SoccerSchedule::Where('league',$lid)->where('matchday',$matchDay)->get();
                return View::make('soccer.matchdayInfo')->with('matchday', $matchDay)->with('league', $league)->with('type', $type)->with('matches',$matches);
            }
        }
        else if($type=='schedule')
        {
            $match = DB::table('soccerschedule')->where('league', '=', $lid)->max('matchday');
            $matchDay = $match + 1;
            return View::make('soccer.matchdayInfo')->with('matchday', $matchDay)->with('league', $league)->with('type',null);
        }
        else
        {
            $match=SoccerSchedule::Where('league','=',$lid)->where('hgoals','=',null)->first();
            $matchDay = $match->matchday;
            return View::make('soccer.matchdayInfo')->with('matchday', $matchDay)->with('league', $league)->with('type',null);
        }

    }

    public function createScheduleTemplate()
    {
        $html=null;
        $lid=Input::get('league');
        $md=Input::get('md');
        $league=SoccerLeague::find($lid);
        $teams=$league->getTeams()->get();
        $html=SoccerAdminController::getFixtures();
        return View::make('soccer.scheduleTemplate')->with('teams',$teams)->with('league',$league)->with('matchday',$md)->with('fixtures',$html);
    }

    public function saveMatchdaySchedule()
    {
        $schedule=json_decode(Input::get('schedule'));
        $numMatches=count($schedule->matches);
        if($numMatches>0)
        {
            for ($i = 0; $i < $numMatches; $i++)
            {
                $match = new SoccerSchedule();
                $match->league = $schedule->league;
                $match->matchday = $schedule->matchday;
                $match->hometeam = $schedule->matches[$i]->hometeam;
                $match->awayteam = $schedule->matches[$i]->awayteam;
                $match->kickoff = $schedule->matches[$i]->kickoff;
                $match->save();
            }
        }
        else
        {
                return 'No';
        }
        return 'Success';
    }

    public function putMatchdayResults()
    {
        $leagues=SoccerLeague::All();
        return View::make('soccer.newSchedule')->with('leagues',$leagues);
    }

    public function createResultsTemplate()
    {
        $lid=Input::get('league');
        $md=Input::get('md');
        $matches=SoccerSchedule::Where('league','=',$lid)->where('matchday','=',$md)->get();
        return View::make('soccer.matchDayResults')->with('matches',$matches);

    }

    public function saveMatchdayResults()
    {
        $results=json_decode(Input::get('results'));
        $numMatches=count($results->predictions);
        if($numMatches>0)
        {
            for($i=0;$i<$numMatches;$i++)
            {
                $match=SoccerSchedule::find($results->predictions[$i]->match);
                $match->hgoals=$results->predictions[$i]->home;
                $match->agoals=$results->predictions[$i]->away;
                $match->save();
                $hscorers=count($results->predictions[$i]->homescorers);
                $ascorers=count($results->predictions[$i]->awayscorers);
                if($hscorers>0)
                {

                    for($j=0;$j<$hscorers;$j++)
                    {
                        $scorer=new SoccerScorer();
                        $scorer->match_id=$results->predictions[$i]->match;
                        $scorer->player_id = $results->predictions[$i]->homescorers[$j]->pid;
                        $scorer->save();
                    }
                }
                if($ascorers >0)
                {
                    for($j=0;$j<$ascorers;$j++)
                    {
                        $scorer=new SoccerScorer();
                        $scorer->match_id=$results->predictions[$i]->match;
                        $scorer->player_id = $results->predictions[$i]->awayscorers[$j]->pid;
                        $scorer->save();
                    }

                }


            }

        }

        return 'Success';
    }

    public function getLeagueStats()
    {
        $leagueTable=null;
        $topScorers=null;
        $url1 = 'http://www.bbc.com/sport/football/premier-league/top-scorers';
        libxml_use_internal_errors(true);
        $page_content = file_get_contents($url1);

        if($page_content != null)
        {
            $dom_obj = new DOMDocument();
            $dom_obj->loadHTML($page_content);


            //First we fetch league table
            foreach ($dom_obj->getElementsByTagName('div') as $meta) {
                if ($meta->getAttribute('class') == 'league-table-content') {
                    $leagueTable = $dom_obj->saveHTML($meta);
                }
            }
            $dom_obj->loadHTML($leagueTable);
            foreach ($dom_obj->getElementsByTagName('caption') as $meta)
            {
                $theOne = $meta->parentNode;
                $theOne->removeChild($meta);
                $leagueTable = $dom_obj->saveHTML($theOne);
                break;
            }
            $dom_obj->loadHTML($leagueTable);
            // Preserve a reference to our DIV container
            $mytb = $dom_obj->getElementsByTagName("table")->item(0);
            $mytb->setAttribute('class','table table-condensed table-hover');

            foreach ($dom_obj->getElementsByTagName('span') as $meta)
            {
                if ($meta->getAttribute('class') == 'no-movement')
                {
                    $theOne = $meta->parentNode;
                    $theOne->removeChild($meta);
                }

            }
            foreach ($dom_obj->getElementsByTagName('a') as $meta)
            {
                $olink=$meta->getAttribute('href');
                $olink='http://bbc.com'.$olink;
                $meta->setAttribute('href',$olink);
            }
            $footDiv = $dom_obj->getElementById('bbccom_sponsor_table-prem');
            $theOne = $footDiv->parentNode;
            $theOne->removeChild($footDiv);
            $leagueTable = $dom_obj->saveHTML($mytb);

            //Here we start fetching Top Scorers
            $dom_obj->loadHTML($page_content);

            foreach ($dom_obj->getElementsByTagName('table') as $meta)
            {
                if ($meta->getAttribute('class') == 'competition-top-scorers-list')
                {
                    $topScorers = $dom_obj->saveHTML($meta);
                    break;
                }
            }
            $dom_obj->loadHTML($topScorers);
            foreach ($dom_obj->getElementsByTagName('caption') as $meta)
            {
                $theOne = $meta->parentNode;
                $theOne->removeChild($meta);
                $topScorers = $dom_obj->saveHTML($theOne);
                break;
            }
            // Preserve a reference to our DIV container
            $mytb = $dom_obj->getElementsByTagName("table")->item(0);
            $mytb->setAttribute('class','table table-condensed table-hover');
            foreach ($dom_obj->getElementsByTagName('a') as $meta)
            {
                $olink=$meta->getAttribute('href');
                $olink='http://bbc.com'.$olink;
                $meta->setAttribute('href',$olink);
            }
            $topScorers = $dom_obj->saveHTML($mytb);

        }

       return View::make('soccer.leagueStats')->with('league',$leagueTable)->with('scorers',$topScorers);
    }

    //this is the code for Live feed
    public function getLivePage()
    {
       //this is for test use
        $mainHandle='everton';
        $count=3;
        $include_retweets=true;
        $exclude_replies=true;
        $twitterfeed=array();
        $twitterfeed = Twitter::getUserTimeline(array('screen_name' => $mainHandle, 'count' => $count, 'include_rts' => $include_retweets, 'exclude_replies' => $exclude_replies, 'trim_user' => true));
        return var_dump($twitterfeed);
    }

    //these are the function related to soccer feeds
    public function getFeedData()
    {
        if (Auth::check())
        {
            $leagueId = Input::get('league');
            $matches = SoccerSchedule::Where('league', $leagueId)->whereNull('hgoals')->get();
            $feeds = new \Illuminate\Database\Eloquent\Collection();
            $newMatches = new \Illuminate\Database\Eloquent\Collection();
            foreach ($matches as $match) {
                $feed = Feed::Where('match_id', $match->id)->first();
                if ($feed != null) {
                    $feeds->add($feed);
                } else {
                    $newMatches->add($match);
                }
            }
            return View::make('soccer.manageFeeds')->with('feeds', $feeds)->with('matches', $newMatches);
        }
        else
        {
            return 'wH@tS!nTheB0x';
        }
    }

    public function createFeed()
    {
        if (Auth::check())
        {
            //this is the logic to create a new feed
            $matchId=Input::get('match');
            $feed= new Feed();
            $feed->match_id=$matchId;
            $feed->save();
            $feed=Feed::Where('match_id',$matchId)->first();
            return '<div class="col-xs-12 col-sm-12 col-md-12" id="feed'.$feed->id.'"><a href="/liveSoccer/'.$feed->id.'">'.SoccerTeam::find(SoccerSchedule::find($feed->match_id)->hometeam)->name.' V '.SoccerTeam::find(SoccerSchedule::find($feed->match_id)->awayteam)->name.'</a><button class="btn btn-default" onclick="stopFeed('.$feed->id.')"> Stop Feed</button><hr></div>';
        }
        else
        {
            return 'wH@tS!nTheB0x';
        }
    }

    public function stopFeed()
    {
        if (Auth::check())
        {
            //this is the logic to create a new feed
            $feedId=Input::get('feedId');
            $feed= Feed::find($feedId);
            $feed->live=false;
            $feed->save();
            return 'Done';
        }
        else
        {
            return 'wH@tS!nTheB0x';
        }
    }

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
        $feedNo=Input::get('feedNo');
        $type=intval(Input::get('type'));
        //if(Session::has('lastCall'))
        $lastCall=new DateTime(Session::get('lastCall'));
        $feed=Feed::find($feedNo);
        $mid=$feed->match_id;
        $matchDetails=SoccerSchedule::find($mid);
        $homeHandle=SoccerTeam::find($matchDetails->hometeam)->handle;
        $awayHandle=SoccerTeam::find($matchDetails->awayteam)->handle;
        $homeTeam=SoccerTeam::find($matchDetails->hometeam)->name;
        $awayTeam=SoccerTeam::find($matchDetails->awayteam)->name;
        $mainHandle='premierleague';
        $count=2;
        $include_retweets=true;
        $exclude_replies=true;
        $twitterfeed=array();
        if($type==0)
        {
            //write the code to fetch premier league tweets

                $twitterfeed = Twitter::getUserTimeline(array('screen_name' => $mainHandle, 'count' => $count, 'include_rts' => $include_retweets, 'exclude_replies' => $exclude_replies, 'trim_user' => true));
                if($twitterfeed==null)
                {
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

                }
                else {
                    foreach ($twitterfeed as $tweet)
                    {
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


        }
        else if($type==1)
        {
            //write the code to fetch home team tweets
            $twitterfeed = Twitter::getUserTimeline(array('screen_name' => $homeHandle, 'count' => $count, 'include_rts' => $include_retweets, 'exclude_replies' => $exclude_replies,'trim_user'=>true));
            if($twitterfeed==null)
            {
                return "";
            }
            $leagueLast=FeedData::Where('feed',$feedNo)->where('type','home')->orderBy('created_at','DESC')->first();
            if($leagueLast==null)
            {
                foreach($twitterfeed as $tweet)
                {
                    $data = new FeedData();
                    $data->feed = $feedNo;
                    $data->username = $homeTeam;
                    $data->comment = $tweet->text;
                    $data->type = 'home';
                    if(property_exists($tweet->entities, 'media'))
                        $data->snap=$tweet->entities->media[0]->media_url;
                    //$data->created_at=date('Y-m-d H:i:s',strtotime($tweet->created_at));
                    $data->created_at = date('Y-m-d H:i:s');
                    $data->save();
                }

            }
            else
            {
                foreach($twitterfeed as $tweet)
                {
                    $tweetTime = new DateTime($tweet->created_at);
                    $lastTime = $leagueLast->created_at;
                    if($tweetTime>$lastTime)
                    {
                        $data = new FeedData();
                        $data->feed = $feedNo;
                        $data->username =$homeTeam;
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

        }
        else if($type==2)
        {
            //write the code to fetch away team tweets
            $twitterfeed = Twitter::getUserTimeline(array('screen_name' => $awayHandle, 'count' => $count, 'include_rts' => $include_retweets, 'exclude_replies' => $exclude_replies,'trim_user'=>true));
            if($twitterfeed==null)
            {
                return "";
            }
            $leagueLast=FeedData::Where('feed',$feedNo)->where('type','away')->orderBy('created_at','DESC')->first();
            if($leagueLast==null)
            {
                foreach($twitterfeed as $tweet)
                {
                    $data = new FeedData();
                    $data->feed = $feedNo;
                    $data->username = $awayTeam;
                    $data->comment = $tweet->text;
                    $data->type = 'away';
                    if(property_exists($tweet->entities, 'media'))
                        $data->snap=$tweet->entities->media[0]->media_url;
                    //$data->created_at=date('Y-m-d H:i:s',strtotime($tweet->created_at));
                    $data->created_at = date('Y-m-d H:i:s');
                    $data->save();
                }

            }
            else
            {

                foreach($twitterfeed as $tweet)
                {
                    $tweetTime = new DateTime($tweet->created_at);
                    $lastTime = $leagueLast->created_at;
                    if($tweetTime>$lastTime)
                    {
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
        else
        {
            //send the complete data without any time boundries
            Session::put('lastCall',date('Y-m-d H:i:s'));
            $feeds=FeedData::where('feed',$feedNo)->orderBy('created_at','DESC')->get();
            return View::make('soccer.livePage')->with('feeds',$feeds);
        }
        $feeds=FeedData::where('feed',$feedNo)->where('created_at','>',$lastCall)->orderBy('created_at','DESC')->get();
        Session::put('lastCall',date('Y-m-d H:i:s'));
        return View::make('soccer.livePage')->with('feeds',$feeds);
    }
    public function saveUserComment()
    {
        $slogan=' ';
        $feedNo=Input::get('feedNo');
        $comment=Input::get('text');
        $lastCall=new DateTime(Session::get('lastCall'));
        $feed=Feed::find($feedNo);
        $user=Auth::user();
        $fanOf=SoccerTeam::find($user->team);
        if($fanOf!=null)
        {
            $slogan=$fanOf->tags;
        }
        $data = new FeedData();
        $data->feed = $feedNo;
        $data->username = '<a href="/user/'.$user->username.'">'.$user->username.'</a>';
        $data->comment = $comment." ".$slogan;
        $data->type = 'fan';
        $data->save();
        //$feeds=FeedData::where('feed',$feedNo)->orderBy('created_at','DESC')->get();
        $feeds=FeedData::where('feed',$feedNo)->where('created_at','>',$lastCall)->orderBy('created_at','DESC')->get();
        Session::put('lastCall',date('Y-m-d H:i:s'));
        return View::make('soccer.livePage')->with('feeds',$feeds);

    }

    public function searchSoccerFriends()
    {
        $flag=false;
        $foundPlayers=new \Illuminate\Database\Eloquent\Collection();
        $keywords=Input::get('name');
        $users=User::all();

            foreach ($users as $player)
            {
                $name = $player->first_name.' '.$player->last_name;
                if (Str::contains(Str::lower($name), Str::lower($keywords)))
                {
                    $flag=true;
                    $foundPlayers->add($player);
                }
            }
            if($flag==true)
            {

                return View::make('soccer.searchedUsers')->with('users',$foundPlayers);
            }
            else
            {
                return "";
            }

    }

    //this is the  function to get the live score
    public function getLiveScore()
    {
        return View::make('soccer.liveScore');
    }

    public function getLiveSoccerLinks()
    {
        if (Auth::check())
        {
            //this is the logic to create a new feed
            $feeds= Feed::Where('live',true)->get();
            return View::make('soccer.liveLinks')->with('feeds',$feeds);
        }

    }


}
