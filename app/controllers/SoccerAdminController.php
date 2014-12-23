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
        $username=Auth::user()->username;
        if($username=='ksjoshi88')
            return View::make('soccer.admin');
        else
            return "<h1>Not Authorized for Admin Page</h1>";
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
                $matches=SoccerSchedule::Where('league',$lid)->where('matchday',$matchDay)->whereNotNull('hgoals')->get();
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
        $matches=SoccerSchedule::Where('league','=',$lid)->where('matchday','=',$md)->where('hgoals','=',null)->get();
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
            $lfeeds = Feed::Where('live',false)->get();
            $newMatches = new \Illuminate\Database\Eloquent\Collection();
            foreach ($matches as $match)
            {
                $feed = Feed::Where('match_id', $match->id)->where('live',true)->first();
                if ($feed != null)
                {
                    $feeds->add($feed);
                }
                else
                {
                    $newMatches->add($match);
                }
            }
            return View::make('soccer.manageFeeds')->with('feeds', $feeds)->with('matches', $newMatches)->with('legacyFeeds',$lfeeds);
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
            $matchDetails=SoccerSchedule::find($matchId);
            $homeTeam=SoccerTeam::find($matchDetails->hometeam);
            $awayTeam=SoccerTeam::find($matchDetails->awayteam);
            $msg=$homeTeam->name.' Vs '.$awayTeam->name.' Live matchfeed in now ON!';
            Action::postAction('newFeed',Auth::user()->id,null,$feed->id,$msg);
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

    public function deleteFeed()
    {
        if (Auth::check())
        {
            //this is the logic to create a new feed
            $feedId=Input::get('feedId');
            $feed= Feed::find($feedId);
            $action=Action::Where('contentid',$feed->id)->first();
            $action->delete();
            $feed->delete();
            return 'Done';
        }
        else
        {
            return 'wH@tS!nTheB0x';
        }
    }

    public function getLiveSoccerLinks()
    {
        if (Auth::check())
        {
            //this is the logic to create a new feed
            $lfeeds= Feed::Where('live',true)->get();
            $cfeeds= Feed::Where('live',false)->get();
            return View::make('soccer.liveLinks')->with('lfeeds',$lfeeds)->with('cfeeds',$cfeeds);
        }

    }

    //this is the function to get the team data on user home page

    public function getTeamData()
    {
        $tid=Input::get('team');
        $url=SoccerTeam::find($tid)->homepage;
        $teamSchedule=null;
        $teamNews=null;
        libxml_use_internal_errors(true);
        $page_content = file_get_contents($url);

        if($page_content != null)
        {
            $dom_obj = new DOMDocument();
            $dom_obj->loadHTML($page_content);
            //First we fetch league table
            foreach ($dom_obj->getElementsByTagName('div') as $meta) {
                if ($meta->getAttribute('class') == 'accordion-container upcoming')
                {
                    $teamSchedule = $dom_obj->saveHTML($meta);
                }
            }
            $dom_obj->loadHTML($teamSchedule);
            // Preserve a reference to our DIV container
            $mytb = $dom_obj->getElementsByTagName("div")->item(0);

            foreach ($dom_obj->getElementsByTagName('a') as $meta)
            {
                $olink=$meta->getAttribute('href');
                $olink='http://bbc.com'.$olink;
                $meta->setAttribute('href',$olink);
            }

            $teamSchedule = $dom_obj->saveHTML($mytb);

            //Here we start fetching Team News
            $dom_obj->loadHTML($page_content);
            $fixDiv = $dom_obj->getElementById('more-headlines');
            $teamNews=$dom_obj->saveHTML($fixDiv);
            $dom_obj->loadHTML($teamNews);
            $mytb = $dom_obj->getElementsByTagName("div")->item(0);
            $newsLinks=array();
            $i=0;
            foreach ($dom_obj->getElementsByTagName('a') as $meta)
            {
                if($i==5)
                    break;
                $olink=$meta->getAttribute('href');
                $olink='http://bbc.com'.$olink;
                array_push($newsLinks,$olink);
                $i++;
               // $meta->setAttribute('href',$olink);
            }


        }

        return View::make('soccer.teamData')->with('schedule',$teamSchedule)->with('newsLinks',$newsLinks);

    }

    public function changeTheTeam()
    {
        $clubId=Input::get('club');
        $user=Auth::user();
        $user->team=$clubId;
        $user->save();
        return 'success';
    }

    //this is the function to search friends of the user
    public function searchFriends()
    {
        $flag=false;
        $foundPlayers=new \Illuminate\Database\Eloquent\Collection();
        $keywords=Input::get('name');
        $users=FriendsController::selectAllFriends();
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

            return View::make('soccer.searchedFriends')->with('users',$foundPlayers);
        }
        else
        {
            return "";
        }

    }
    //these are admin related functions
    public function calculatePredictionResults()
    {
        $tifc=0;
        $ifc=0;
        $tp=0;
        $users=array();
        $matchDay = DB::table('soccerschedule')->whereNotNull('hgoals')->max('matchday');
        $matches=SoccerSchedule::Where('matchday',$matchDay)->get();
        foreach($matches as $match)
        {
            $tp=0;
            $ifc=0;
            $tifc=0;
            $matchScorers=SoccerScorer::Where('match_id',$match->id)->select('player_id')->get();
            $scorers=array();
            foreach($matchScorers as $ms)
            {
                array_push($scorers,$ms->player_id);
            }
            $matchPredictions = SoccerScorePredictions::Where('match_id',$match->id)->get();
            foreach ($matchPredictions as $matchPrediction)
            {
                    $tp=0;
                    $ifc=0;
                    $tifc=0;
                    if ($matchPrediction->ifc === null)
                    {
                        $tp=150;
                        $ifc = 0;
                        if ($matchPrediction->hgoals == $match->hgoals)
                        {
                            $ifc += 50;
                        }
                        if ($matchPrediction->agoals == $match->agoals)
                        {
                            $ifc += 50;
                        }
                        DB::table('soccerscorepredictions')->where('match_id', $matchPrediction->match_id)->where('user_id', $matchPrediction->user_id)->update(array('ifc' => $ifc));

                    }
                    $tifc += $ifc;
                    $user=User::find($matchPrediction->user_id);
                    $userPredictions=DB::table('soccerscorerpredictions')->where('user_id',$user->id)->where('match_id',$matchPrediction->match_id)->whereNull('ifc')->select('player_id')->get();
                    if(count($userPredictions)>0)
                    {
                        DB::table('soccerscorerpredictions')->where('match_id', $match->id)->where('user_id', $user->id)->update(array('ifc' => 0));
                        $tp+=50*intval($match->hgoals)+50*intval($match->agoals);
                        $uscorers=array();
                        foreach($userPredictions as $us)
                        {
                           array_push($uscorers,$us->player_id);
                        }
                        $result=array_intersect($uscorers,$scorers);
                        $ifc=count($result)*50;
                        foreach($result as $sp)
                        {
                            DB::table('soccerscorerpredictions')->where('match_id', $match->id)->where('player_id', $sp)->where('user_id', $user->id)->update(array('ifc' => 50));
                        }
                        $tifc+=$ifc;
                    }
                    if ($tifc > 0)
                    {

                        $user->profile->ifc += $tifc;
                        $user->profile->save();
                        TransactionController::insertToManager($user->id, "+" . $tifc, "Earnings from correct soccer score predictions", "nope", "nope", "nope");
                        array_push($users,$user->id);
                    }
                    $pe = PredictEarning::find($user->id);
                    if ($pe == null)
                    {
                        $pe = new PredictEarning();
                        $pe->id = $user->id;
                        $pe->ifc = $tifc;
                        $pe->total=$tp;
                        $pe->save();
                    }
                    else
                    {
                        $pe->ifc += $tifc;
                        $pe->total+= $tp;
                        $pe->save();
                    }
            }

        }
        $uusers=array_unique($users);
        foreach($uusers as $user)
        {
            AjaxController::insertToNotification($user, Auth::user()->id, "transfered", "Soccer Prediction results are out, check how much you earned!", 'http://b2.com/playPredictor');
        }
        return 'Done';
    }

    //this is the function to simulate the soccer
    public function simulateSoccer()
    {
        $user=User::find(Input::get('uid'));
        $matchDay = DB::table('soccerschedule')->whereNotNull('hgoals')->max('matchday');
        $matches=SoccerSchedule::Where('matchday',$matchDay)->get();

        foreach($matches as $match)
        {
            //$limit=rand(0,3);
            $hp=rand(0,3);
            $ap=rand(0,3);
            DB::table('soccerscorepredictions')->insert(array('match_id' => $match->id, 'hgoals'=>$hp,'agoals'=>$ap,'user_id'=>$user->id));
        }
        return 'Done';

    }



}
