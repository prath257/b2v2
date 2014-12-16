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
                        return "<p>Player not found for this team</p>";
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






}
