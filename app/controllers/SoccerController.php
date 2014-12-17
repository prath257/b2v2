<?php

class SoccerController extends \BaseController
{
    public function getSoccerSpace()
    {
        $user=Auth::user();
        return View::make('soccer.soccerSpace')->with('user',$user);
    }

   //These are functions for predictor use case

    public function getPredictor()
    {
        $leagues=SoccerLeague::All();
        return View::make('soccer.soccerPredictor')->with('leagues',$leagues);
    }

    public function getMatchDay()
    {
        $lid=Input::get('league');
        $league=SoccerLeague::find($lid);
        $match=SoccerSchedule::Where('league','=',$lid)->where('hgoals','=',null)->first();
        return View::make('soccer.matchdayInfo')->with('matchday',$match->matchday)->with('league',$league);
    }

    public function getMatches()
    {
        $lid=Input::get('league');
        $md=Input::get('matchday');
        $currentTime=time()+3600;
        $deadLine=date('Y-m-d H:i:s',$currentTime);
        $matches=SoccerSchedule::Where('league','=',$lid)->where('matchday','=',$md)->where('kickoff', '>', $deadLine)->get();
        $fmatches=new \Illuminate\Database\Eloquent\Collection();

        foreach($matches as $match)
        {
            $fmatch=SoccerScorePredictions::Where('user_id',Auth::user()->id)->where('match_id',$match->id)->first();
            if($fmatch==null)
            {
                $fmatches->add($match);
            }

        }
        return View::make('soccer.matchdaySchedule')->with('matches',$fmatches);
    }

    public function getScorerMarkup()
    {
        $mid=Input::get('match');
        $hg=Input::get('home');
        $ag=Input::get('away');
        $match=SoccerSchedule::find($mid);
        return View::make('soccer.scorerMarkup')->with('match',$match)->with('hg',$hg)->with('ag',$ag);
    }

    public function saveMatchPredictions()
    {
        $predict=json_decode(Input::get('predictions'));
        $userid=Auth::user()->id;
        $numMatches=count($predict->predictions);
        if($numMatches>0)
        {
            for($i=0;$i<$numMatches;$i++)
            {
                $scorePrediction=new SoccerScorePredictions();
                $scorePrediction->match_id=$predict->predictions[$i]->match;
                $scorePrediction->hgoals=$predict->predictions[$i]->home;
                $scorePrediction->agoals=$predict->predictions[$i]->away;
                $scorePrediction->user_id=$userid;
                $scorePrediction->save();
                $hscorers=count($predict->predictions[$i]->homescorers);
                $ascorers=count($predict->predictions[$i]->awayscorers);
                if($hscorers>0)
                {

                    for($j=0;$j<$hscorers;$j++)
                    {
                        $scorerPrediction=new SoccerScorerPredictions();
                        $scorerPrediction->match_id=$predict->predictions[$i]->match;
                        $scorerPrediction->player_id = $predict->predictions[$i]->homescorers[$j]->pid;
                        $scorerPrediction->user_id=$userid;
                        $scorerPrediction->save();
                    }
                }
                if($ascorers >0)
                {
                    for($j=0;$j<$ascorers;$j++)
                    {
                        $scorerPrediction=new SoccerScorerPredictions();
                        $scorerPrediction->match_id=$predict->predictions[$i]->match;
                        $scorerPrediction->player_id = $predict->predictions[$i]->awayscorers[$j]->pid;
                        $scorerPrediction->user_id=$userid;
                        $scorerPrediction->save();
                    }

                }
                

            }

        }

        return 'Success';
    }

    //Functions related to getting a users prediction scores
    public function getResultsView()
    {
        return View::make('soccer.predictionResultsTable');
    }

    public function getScoreResults()
    {
        SoccerController::calculateScoreIFCs();
        $userid=Auth::user()->id;
        $matchPredictions=Auth::user()->getScorePredictions()->get();
        return Datatable::collection($matchPredictions)
            ->addColumn('League',function($model)
            {
                $match=SoccerSchedule::find($model->match_id);
                return SoccerLeague::find($match->league)->name;
            })
            ->addColumn('Matchday',function($model)
            {
                $match=SoccerSchedule::find($model->match_id);
                return $match->matchday;
            })
            ->addColumn('Match',function($model)
            {
                $match=SoccerSchedule::find($model->match_id);
                return SoccerTeam::find($match->hometeam)->name.' Vs '.SoccerTeam::find($match->awayteam)->name;
            })
            ->addColumn('Prediction',function($model)
            {
                return $model->hgoals.'-'.$model->agoals;
            })
            ->addColumn('Final Score',function($model)
            {
                $match=SoccerSchedule::find($model->match_id);
                return $match->hgoals.'-'.$match->agoals;
            })
            ->addColumn('Earning',function($model)
            {
                return $model->ifc;
            })
            ->make();

    }

    public static function calculateScoreIFCs()
    {
        $ifc=0;
        $user=Auth::user();
        $matchPredictions=Auth::user()->getScorePredictions()->get();
        foreach($matchPredictions as $matchPrediction)
        {
            if($matchPrediction->ifc==null)
            {
                $ifc=0;
                $match=SoccerSchedule::find($matchPrediction->match_id);
                if($matchPrediction->hgoals==$match->hgoals)
                {
                    $ifc+=50;
                }
                if($matchPrediction->agoals==$match->agoals)
                {
                    $ifc+=50;
                }

                DB::table('soccerscorepredictions')->where('match_id',$matchPrediction->match_id)->where('user_id', $user->id)->update(array('ifc' => $ifc));

            }
            $user->profile->ifc += $ifc;
            $user->profile->save();
        }

    }
    public function getScorerResults()
    {
        SoccerController::calculateScorerIFCs();
        $userid=Auth::user()->id;
        $matchList=new \Illuminate\Database\Eloquent\Collection();
        $matches=DB::table('soccerscorerpredictions')->select('match_id')->where('user_id', '=',$userid)->distinct()->get();
        foreach($matches as $match)
        {
            $matchList->add($match);
        }
        return Datatable::collection($matchList)
            ->addColumn('Match',function($model)
            {
                $match=SoccerSchedule::find($model->match_id);
                return SoccerTeam::find($match->hometeam)->name.' Vs '.SoccerTeam::find($match->awayteam)->name;
            })
            ->addColumn('Your Scorers',function($model)
            {
                //Get all predicted scorers for this perticular match
                $pscorers='';
                $players=SoccerScorerPredictions::Where('user_id','=',Auth::user()->id)->where('match_id','=',$model->match_id)->get();
                foreach($players as $player)
                {
                    $pscorers=$pscorers.'| '.SoccerPlayer::find($player->player_id)->last_name.' ';
                }
                return $pscorers;
            })
            ->addColumn('Actual Scorers',function($model)
            {
                $pscorers='';
                $players=SoccerScorer::Where('match_id','=',$model->match_id)->get();
                foreach($players as $player)
                {
                    $pscorers=$pscorers.'| '.SoccerPlayer::find($player->player_id)->last_name.' ';
                }
                return $pscorers;
            })
            ->addColumn('Earning',function($model)
            {
                $ifcs=DB::table('soccerscorerpredictions')->select(DB::raw('sum(ifc) as total'))->where('match_id', '=',$model->match_id)->groupBy('match_id')->get();
                return $ifcs[0]->total;
            })
            ->make();
    }

    public static function calculateScorerIFCs()
    {
        $ifc=0;
        $user=Auth::user();
        $scorerPredictions=Auth::user()->getScorerPredictions()->get();
        foreach($scorerPredictions as $scorer)
        {
            if($scorer->ifc==null)
            {
                $ifc=0;
                $scorerMatch=SoccerScorer::Where('match_id','=',$scorer->match_id)->where('player_id','=',$scorer->player_id)->first();
                if($scorerMatch!=null)
                {
                    $ifc = 50;
                }

                DB::table('soccerscorerpredictions')->where('match_id',$scorer->match_id)->where('player_id', $scorer->player_id)->where('user_id', $user->id)->update(array('ifc' => $ifc));

            }
            $user->profile->ifc += $ifc;
            $user->profile->save();

        }

    }

    //This is the function to get friends Predictions
    public function getFriendsPredictions()
    {
        $mid=Input::get('matchId');
        $userid=Auth::user()->id;
        $friends1=DB::table('friends')->where('friend1','=',$userid)->where('status','=','accepted')->lists('friend2');
        $friends2=DB::table('friends')->where('friend2','=',$userid)->where('status','=','accepted')->lists('friend1');
        $friends = array_merge($friends1, $friends2);
        $friendData=new stdClass();
        $found=false;
        if(count($friends)>0)
        {
             $friendData->match=$mid;
             $friendData->fpredict=array();
             foreach($friends as $friend)
             {
                 $score=SoccerScorePredictions::Where('match_id',$mid)->where('user_id',$friend)->first();
                 if($score!=null)
                 {
                    $predictData=new stdClass();
                    $predictData->fid=$friend;
                    $predictData->hgoals=$score->hgoals;
                    $predictData->agoals=$score->agoals;
                    $predictData->scorers=array();
                    $scorers=SoccerScorerPredictions::Where('match_id',$mid)->where('user_id',$friend)->get();
                     if(count($scorers)>0)
                     {

                         $i=0;
                         foreach($scorers as $scorer)
                         {
                             $predictData->scorers[$i]=$scorer->player_id;
                             $i++;
                         }
                     }
                     array_push($friendData->fpredict,$predictData);
                     $found=true;

                 }

             }
             if($found==true)
             {
                 $homeTeam = SoccerTeam::find(SoccerSchedule::find($mid)->hometeam)->name;
                 $awayTeam = SoccerTeam::find(SoccerSchedule::find($mid)->awayteam)->name;
                 return View::make('soccer.friendsPrediction')->with('friendsData', $friendData)->with('home',$homeTeam)->with('away',$awayTeam);
             }
             else
             {
                 return "<h3> No Predictions by your friends found for current Matchday</h3>";
             }
        }
        else
        {
            return "<h3> No Predictions by your friends found for current Matchday</h3>";
        }


    }

    //These are the functions related to player ratings use case
    public function getRatingsPage()
    {
        return View::make('soccer.playerRatings');
    }

    public function getSquad()
    {
        $matchid=Input::get('mid');
        $side=Input::get('side');
        $match=SoccerSchedule::find($matchid);
        $gks=new Illuminate\Database\Eloquent\Collection();
        $dfs=new Illuminate\Database\Eloquent\Collection();
        $mfs=new Illuminate\Database\Eloquent\Collection();
        $ffs=new Illuminate\Database\Eloquent\Collection();
        if($side=='Home')
        {
            $team=SoccerTeam::find($match->hometeam);
            $squad=$team->getPlayers()->get();
        }
        else
        {
            $team=SoccerTeam::find($match->awayteam);
            $squad=$team->getPlayers()->get();
        }
        foreach($squad as $player)
        {
            if($player->position=='Goalkeeper')
            {
                $gks->add($player);
            }
            else if($player->position=='Defender')
            {
                $dfs->add($player);
            }
            else if($player->position=='Midfielder')
            {
                $mfs->add($player);
            }
            else
            {
                $ffs->add($player);
            }

        }
        return View::make('soccer.getSquad')->with('goalies',$gks)->with('midfield',$mfs)->with('defence',$dfs)->with('forwards',$ffs)->with('side',$side);
    }

    public function getRatingsTemplate()
    {
        $side=Input::get('side');
        $players=Input::get('players');
        $man=SoccerPlayer::find($players[0]);
        $team=$man->getTeam()->first();
        $squad=new \Illuminate\Database\Eloquent\Collection();
        foreach($players as $player)
        {
            $squad->add(SoccerPlayer::find($player));
        }
        return View::make('soccer.ratingsTemplate')->with('squad',$squad)->with('team',$team)->with('side',$side);
    }

    public function checkMatchRatings()
    {
        $matchid=Input::get('mid');
        $records=DB::table('soccerratings')->where('user_id',Auth::user()->id)->where('match_id',$matchid)->first();
        if($records!=null)
        {
            return 'Found';
        }
        else
        {
            return 'New';
        }
    }

    public function saveMatchRatings()
    {
        $matchratings=json_decode(Input::get('matchratings'));
        $userid=Auth::user()->id;
        $matchid=Input::get('matchid');
        $mid=intval($matchid);
        $numratings=count($matchratings->ratings);
        if($numratings>0)
        {
            for ($i = 0; $i < $numratings; $i++)
            {
                DB::table('soccerratings')->insert(array('match_id' => $mid, 'user_id' =>$userid,'player_id'=>intval($matchratings->ratings[$i]->pid),'comment'=>$matchratings->ratings[$i]->comment,'rating'=>floatval($matchratings->ratings[$i]->score)));
            }
        }
        return 'Success';

    }

    public function getMatchRatings($mid,$userid=null)
    {
        if($userid==null)
        {
            $userid=Auth::user()->id;
        }
        $matchDetails=SoccerSchedule::find($mid);
        $records=$records=DB::table('soccerratings')->where('user_id',$userid)->where('match_id',$mid)->get();
        $author=User::find($userid);
        return View::make('soccer.matchRatings')->with('match',$matchDetails)->with('ratings',$records)->with('author',$author);

    }

    public function getMyRatings()
    {
        return View::make('soccer.myRatings');
    }

    public function getMyRatingsTable()
    {
        $userid=Auth::user()->id;
        $matchList=new \Illuminate\Database\Eloquent\Collection();
        $matches=DB::table('soccerratings')->select('match_id')->where('user_id', '=',$userid)->distinct()->get();
        foreach($matches as $match)
        {
            $matchList->add($match);
        }
        return Datatable::collection($matchList)
            ->addColumn('League',function($model)
            {
                $match=SoccerSchedule::find($model->match_id);
                return SoccerLeague::find($match->league)->name;
                return SoccerTeam::find($match->hometeam)->name.' Vs '.SoccerTeam::find($match->awayteam)->name;
            })
            ->addColumn('My Ratings',function($model)
            {
                $match=SoccerSchedule::find($model->match_id);
                $title=SoccerTeam::find($match->hometeam)->name.' Vs '.SoccerTeam::find($match->awayteam)->name;
                return "<a href='/getMatchRatings/".$model->match_id."'>".$title."</a>";
            })
            ->make();
    }

    public function getFriendsRatings()
    {
        return View::make('soccer.friendsRatings');
    }

    public function getFriendsRatingsTable()
    {
        $userid=Auth::user()->id;
        $friends1=DB::table('friends')->where('friend1','=',$userid)->where('status','=','accepted')->lists('friend2');
        $friends2=DB::table('friends')->where('friend2','=',$userid)->where('status','=','accepted')->lists('friend1');
        $friends = array_merge($friends1, $friends2);
        $matchList=new \Illuminate\Database\Eloquent\Collection();
        if(count($friends)>0)
        {
            foreach($friends as $friend)
            {
                $matches = DB::table('soccerratings')->select('match_id','user_id')->where('user_id', '=', $friend)->distinct()->get();
                foreach ($matches as $match)
                {
                    $matchList->add($match);
                }
            }
        }
        return Datatable::collection($matchList)
            ->addColumn('Match',function($model)
            {
                $match=SoccerSchedule::find($model->match_id);
                $title=SoccerTeam::find($match->hometeam)->name.' Vs '.SoccerTeam::find($match->awayteam)->name;
                return "<a href='/getMatchRatings/".$model->match_id."/".$model->user_id."'>".$title."</a>";
            })
            ->addColumn('Owner',function($model)
            {
                $user=User::find($model->user_id);
                return "<a href='/user/".$user->username."'>".$user->first_name." ".$user->last_name."</a>";
            })
            ->make();
    }




}
