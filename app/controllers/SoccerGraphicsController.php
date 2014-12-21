<?php

class SoccerGraphicsController extends \BaseController
{

     public function getMyBestRatings()
     {
         $finalData=array();
         $bestPlayers=DB::table('soccerratings')->select(DB::raw('avg(rating) as avg_rating, player_id'))->where('user_id',Auth::user()->id)->groupBy('player_id')->orderBy('avg_rating', 'desc')->take(5)->get();
         $lim=count($bestPlayers);
         if($lim>0)
         {
             for($i=0;$i<$lim;$i++)
             {
                 $playerName=SoccerPlayer::find($bestPlayers[$i]->player_id)->last_name;
                 $finalData[$i] = array('player' => $playerName, 'avg_rating' => $bestPlayers[$i]->avg_rating);
             }

         }
         return $finalData;
     }

    public function getFriendsBestRatings()
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
                $matches = DB::table('soccerratings')->where('user_id', '=', $friend)->get();
                foreach ($matches as $match)
                {
                    $matchList->add($match);
                }
            }
        }
        $finalData=array();
        //$bestPlayers=DB::collection($matchList)->select(DB::raw('avg(rating) as avg_rating, player_id'))->where('user_id',Auth::user()->id)->groupBy('player_id')->orderBy('avg_rating', 'desc')->take(5)->get();
        $bestPlayers=$matchList->groupBy('player_id');
        $newCollect = $bestPlayers->map(function($players)
        {
            $sum=0;
            $count=0;
            $avg_rating=0;
            $record=new stdClass();
            $record->player_id=$players[0]->player_id;
            foreach($players as $player)
            {
                $count++;
                $sum+=$player->rating;
            }
            $avg_rating=round($sum/$count,2);
            $record->average=$avg_rating;
            return $record;
        });
        $bestPlayers=$newCollect->sortByDesc('average')->take(5);
        $lim=count($bestPlayers);
        if($lim>0)
        {
            for($i=0;$i<$lim;$i++)
            {
                $playerName=SoccerPlayer::find($bestPlayers[$i]->player_id)->last_name;
                $finalData[$i] = array('player' => $playerName, 'avg_rating' => $bestPlayers[$i]->average);
            }

        }
        return $finalData;
    }

    public function searchPlayerComments()
    {
        if (Auth::check())
        {
            $flag=false;
            $foundPlayers=new \Illuminate\Database\Eloquent\Collection();
            $keywords = Input::get('player');
            $type=Input::get('type');
            if($type=='my')
            {
                $myRatings=DB::table('soccerratings')->select('player_id')->where('user_id',Auth::user()->id)->distinct('player_id')->get();

                    foreach ($myRatings as $player)
                    {
                        $p = SoccerPlayer::find($player->player_id);
                        $name = $p->first_name . ' ' . $p->last_name;
                        if (Str::contains(Str::lower($name), Str::lower($keywords)))
                        {
                            $flag=true;
                            $foundPlayers->add($p);
                        }
                    }
                if($flag==true)
                {

                    return View::make('soccer.searchedPlayers')->with('players',$foundPlayers)->with('type',$type);;
                }
                else
                {
                    return "<p>No Comments from you for him</p>";
                }
            }
            else if($type=='friends')
            {
                $userid=Auth::user()->id;
                $friends1=DB::table('friends')->where('friend1','=',$userid)->where('status','=','accepted')->lists('friend2');
                $friends2=DB::table('friends')->where('friend2','=',$userid)->where('status','=','accepted')->lists('friend1');
                $friends = array_merge($friends1, $friends2);
                $playerList=new \Illuminate\Database\Eloquent\Collection();
                if(count($friends)>0)
                {
                    foreach($friends as $friend)
                    {
                        $players=DB::table('soccerratings')->select('player_id')->where('user_id',$friend)->distinct('player_id')->get();
                        foreach ($players as $player)
                        {
                            $playerList->add($player);
                        }
                    }
                    $newplayerList=array();
                    foreach($playerList as $player)
                    {
                        array_push($newplayerList,$player->player_id);
                    }
                    $newplayerList=array_unique($newplayerList);
                    foreach ($newplayerList as $player)
                    {
                        $p = SoccerPlayer::find($player);
                        $name = $p->first_name . ' ' . $p->last_name;
                        if (Str::contains(Str::lower($name), Str::lower($keywords)))
                        {
                            $flag=true;
                            $foundPlayers->add($p);
                        }
                    }
                    if($flag==true)
                    {
                        return View::make('soccer.searchedPlayers')->with('players',$foundPlayers)->with('type',$type);
                    }
                    else
                    {
                        return "<p>No Comments from your friends for him</p>";
                    }
                }
                else
                {
                    return "<p>You have no friends.</p>";
                }

            }
            else
            {
                $players=SoccerPlayer::Where('team',$type)->get();
                $playerList=new \Illuminate\Database\Eloquent\Collection();
                if(count($players)>0)
                {
                    foreach($players as $friend)
                    {
                        $players=DB::table('soccerratings')->select('player_id')->where('player_id',$friend->id)->get();
                        foreach ($players as $player)
                        {
                            $playerList->add($player);
                        }
                    }
                    $newplayerList=array();
                    foreach($playerList as $player)
                    {
                        array_push($newplayerList,$player->player_id);
                    }
                    $newplayerList=array_unique($newplayerList);
                    foreach ($newplayerList as $player)
                    {
                        $p = SoccerPlayer::find($player);
                        $name = $p->first_name . ' ' . $p->last_name;
                        if (Str::contains(Str::lower($name), Str::lower($keywords)))
                        {
                            $flag=true;
                            $foundPlayers->add($p);
                        }
                    }
                    if($flag==true)
                    {
                        return View::make('soccer.searchedPlayers')->with('players',$foundPlayers)->with('type',$type);
                    }
                    else
                    {
                        return "<p>No Comments found!</p>";
                    }
                }

            }

        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getPlayerComments()
    {
        if (Auth::check())
        {
            $playerId = Input::get('player');
            $type=Input::get('type');
            if($type=='my')
            {
                $myComments=DB::table('soccerratings')->where('user_id',Auth::user()->id)->where('player_id',$playerId)->get();
                return View::make('soccer.playerComments')->with('comments',$myComments);
            }
            else if($type=='friends')
            {
                $userid=Auth::user()->id;
                $friends1=DB::table('friends')->where('friend1','=',$userid)->where('status','=','accepted')->lists('friend2');
                $friends2=DB::table('friends')->where('friend2','=',$userid)->where('status','=','accepted')->lists('friend1');
                $friends = array_merge($friends1, $friends2);
                $commentsList=new \Illuminate\Database\Eloquent\Collection();
                if(count($friends)>0)
                {
                    foreach($friends as $friend)
                    {
                        $comments=DB::table('soccerratings')->where('user_id',$friend)->where('player_id',$playerId)->get();
                        foreach ($comments as $comment)
                        {
                            $commentsList->add($comment);
                        }
                    }
                }
                return View::make('soccer.playerComments')->with('comments',$commentsList);
            }
            else
            {
                $myComments=DB::table('soccerratings')->where('player_id',$playerId)->get();
                return View::make('soccer.playerComments')->with('comments',$myComments);
            }

        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getClubRatingsView()
    {
            return View::make('soccer.clubRatings');
    }

    public function searchClub()
    {
        if (Auth::check())
        {
            $flag = false;
            $foundClubs = new \Illuminate\Database\Eloquent\Collection();
            $keywords = Input::get('club');
            $clubs=SoccerTeam::all();
            foreach ($clubs as $club)
            {
                if (Str::contains(Str::lower($club->name), Str::lower($keywords)))
                {
                    $flag = true;
                    $foundClubs->add($club);
                }
            }
            if ($flag == true)
            {
                return View::make('soccer.searchedClubs')->with('clubs', $foundClubs);
            }
            else
            {
                return "<p>No Clubs by this name found</p>";
            }

        }
        else
        {
            return 'wH@tS!nTheB0x';
        }
    }

    public function fetchClubRatings()
    {
        if (Auth::check())
        {
             $clubId=Input::get('club');
             $club=SoccerTeam::find($clubId);
             return View::make('soccer.clubStats')->with('club',$club);
        }
        else
        {
            return 'wH@tS!nTheB0x';
        }
    }

    public function getclubBestRatings()
    {
        $clubId=Input::get('days');
        $players=SoccerPlayer::Where('team',$clubId)->get();
        $finalData=array();
        $matchList=new \Illuminate\Database\Eloquent\Collection();
        if(count($players)>0)
        {
            foreach($players as $friend)
            {
                $matches = DB::table('soccerratings')->where('player_id', '=', $friend->id)->get();
                foreach ($matches as $match)
                {
                    $matchList->add($match);
                }
            }
        }
        $bestPlayers=$matchList->groupBy('player_id');
        $newCollect = $bestPlayers->map(function($players)
        {
            $sum=0;
            $count=0;
            $avg_rating=0;
            $record=new stdClass();
            $record->player_id=$players[0]->player_id;
            foreach($players as $player)
            {
                $count++;
                $sum+=$player->rating;
            }
            $avg_rating=round($sum/$count,2);
            $record->average=$avg_rating;
            return $record;
        });
        $bestPlayers=$newCollect->sortByDesc('average')->take(5);
        $lim=count($bestPlayers);
        if($lim>0)
        {
            for($i=0;$i<$lim;$i++)
            {
                $playerName=SoccerPlayer::find($bestPlayers[$i]->player_id)->last_name;
                $finalData[$i] = array('player' => $playerName, 'avg_rating' => $bestPlayers[$i]->average);
            }

        }
        return $finalData;

    }

    public function searchPlayer()
    {
      if(Auth::check())
      {
          $type=Input::get('type');
          $flag = false;
          $foundPlayers = new \Illuminate\Database\Eloquent\Collection();
          $keywords = Input::get('player');
          $teamId = Input::get('team');
          $players = SoccerTeam::find($teamId)->getPlayers()->get();
          foreach ($players as $player)
          {
              $name = $player->first_name . ' ' . $player->last_name;
              if (Str::contains(Str::lower($name), Str::lower($keywords)))
              {
                  $flag = true;
                  $foundPlayers->add($player);
              }
          }
          if ($flag == true)
          {

              return View::make('soccer.playerSearch')->with('players', $foundPlayers)->with('type', $type);;
          }
          else
          {
              return "<p>No Player by this name</p>";
          }

      }
      else
      {

      }

    }

    public function searchScorer()
    {
        if(Auth::check())
        {
            $type=Input::get('type');
            $flag = false;
            $foundPlayers = new \Illuminate\Database\Eloquent\Collection();
            $keywords = Input::get('player');
            $home = Input::get('homeSide');
            $away = Input::get('awaySide');
            $players = SoccerPlayer::Where('team',$home)->orWhere('team',$away)->get();
            foreach ($players as $player)
            {
                $name = $player->first_name . ' ' . $player->last_name;
                if (Str::contains(Str::lower($name), Str::lower($keywords)))
                {
                    $flag = true;
                    $foundPlayers->add($player);
                }
            }
            if ($flag == true)
            {

                return View::make('soccer.playerSearch')->with('players', $foundPlayers)->with('type', $type);;
            }
            else
            {
                return "<p>No Player by this name</p>";
            }

        }
        else
        {

        }

    }

    //these are the functions to get prediction stats

    public function getPredictStats()
    {
        $te=0;
        $pe=PredictEarning::find(Auth::user()->id);
        if($pe!=null)
        {
            $te=$pe->ifc;
        }
        return View::make('soccer.predictStats')->with('totalEarning',$te);
    }

    public function getPredictPercent()
    {
        if(Auth::check())
        {
            $user=Auth::user();
            $tifc=0;
            $ifc=0;
            $total=0;
            $totalIFC=0;
            $tpossible=0;
            //First Lets Calculate Score Accuracy
            $matchPredictions=Auth::user()->getScorePredictions()->get();
            foreach($matchPredictions as $matchPrediction)
            {
                $match=SoccerSchedule::find($matchPrediction->match_id);
                if($match->hgoals!=null)
                {

                        $ifc = 0;
                        if ($matchPrediction->hgoals == $match->hgoals)
                        {
                            $ifc += 50;
                        }
                        if ($matchPrediction->agoals == $match->agoals)
                        {
                            $ifc += 50;
                        }
                        $tpossible+=100;
                        $tifc+=$ifc;
                }
            }
            $totalIFC=$tifc;
            $total=$tpossible;
            $scoreAccuracy=($tifc/$tpossible)*100;
            $scoreAccuracy=round($scoreAccuracy,2);

            //Now Lets Calculate Scorer Accuracy
            $tifc=0;
            $tpossible=0;
            $ifc=0;
            $scorerPredictions=Auth::user()->getScorerPredictions()->get();
            $matches=DB::table('soccerscorerpredictions')->select('match_id')->where('user_id', '=',$user->id)->distinct()->get();
            foreach($matches as $match)
            {
                $matchDetails=SoccerSchedule::find($match->match_id);
                if($matchDetails->hgoals!=null)
                   $tpossible+=50*intval($matchDetails->hgoals)+50*intval($matchDetails->agoals);
            }
            foreach($scorerPredictions as $scorer)
            {
                $match=SoccerSchedule::find($scorer->match_id);
                if($match->hgoals!=null)
                {
                        $ifc = 0;
                        $scorerMatch = SoccerScorer::Where('match_id', '=', $scorer->match_id)->where('player_id', '=', $scorer->player_id)->first();
                        if ($scorerMatch != null)
                        {
                            $ifc = 50;
                        }
                        $tifc+=$ifc;
                }

            }
            $scorerAccuracy=($tifc/$tpossible)*100;
            $scorerAccuracy=round($scorerAccuracy,2);
            $stats=array();
            $stats[0]=array('label'=>'Score Accuracy %','value'=>$scoreAccuracy);
            $stats[1]=array('label'=>'Scorers Accuracy %','value'=>$scorerAccuracy);
            return $stats;

        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getLeaderboard()
    {
        return View::make('soccer.leaderBoard');
    }

    public function getLeaderboardData()
    {
        $user=Auth::user();
        $leaders=PredictEarning::orderBy('ifc','DESC')->get();
        $leaderList=new \Illuminate\Database\Eloquent\Collection();
        if(count($leaders)>0)
        {
            $r=1;
            foreach($leaders as $leader)
            {
                $player=new stdClass();
                $player->rank=$r;
                $player->id=$leader->id;
                $player->earning=$leader->ifc;
                $player->total=$leader->total;
                $leaderList->add($player);
                $r++;
            }
        }
        return Datatable::collection($leaderList)
            ->orderColumns('accuracy','earnings')
            ->addColumn('rank',function($model)
            {
                return $model->rank;
            })
            ->addColumn('name',function($model)
            {
                $name=User::find($model->id)->first_name.' '.User::find($model->id)->last_name;
                return $name;
            })
            ->addColumn('accuracy',function($model)
            {
                if($model->total==0)
                    return 0;
                else
                {
                    $accuracy=round(intval($model->earning)/intval($model->total),2)*100;
                    return $accuracy;
                }
            })
            ->addColumn('earnings',function($model)
            {
                return $model->earning;
            })
            ->addColumn('country',function($model)
            {
                $country=User::find($model->id)->country;
                return $country;
            })
            ->make();
    }





}
