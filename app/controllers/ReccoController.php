<?php

class ReccoController extends \BaseController {

    public function post_recco()
    {
        if (Auth::check())
        {
            $url = Input::get('url');
            libxml_use_internal_errors(true);
            $page_content = file_get_contents($url);

            if($page_content != null)
            {
                $imagePath = 'http://b2.com/Images/recco.jpg';
                $descript=null;
                preg_match("/<title>(.*)<\/title>/i", $page_content, $titles);
                $title=$titles[1];
                $dom_obj = new DOMDocument();
                $dom_obj->loadHTML($page_content);

                $images = $dom_obj->getElementsByTagName('img');
                foreach ($images as $tag)
                {
                    $imagePath=$tag->getAttribute('src');
                    break;
                }

                foreach($dom_obj->getElementsByTagName('meta') as $meta)
                {
                    if($meta->getAttribute('property')=='og:title')
                    {
                        $title = $meta->getAttribute('content');
                    }
                    if($meta->getAttribute('name')=='description')
                    {
                        $descript = $meta->getAttribute('content');
                    }
                    if($meta->getAttribute('property')=='og:description')
                    {
                        $descript = $meta->getAttribute('content');
                    }
                    if($meta->getAttribute('property')=='og:image')
                    {
                        $imagePath = $meta->getAttribute('content');
                    }
                }

                return View::make('recco_preview')->with('title',$title)->with('description',$descript)->with('image',$imagePath);
            }
            else
                return 'failure';
        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function publish_recco()
    {
        if (Auth::check())
        {
            $recco = new Recco();
            $recco->userid = Auth::user()->id;
            $recco->url = Input::get('url');
            $recco->title = Input::get('title');
            $recco->description = Input::get('desc');
            $recco->image = Input::get('image');
            $recco->save();

            Auth::user()->profile->ifc += 20;
            Auth::user()->profile->save();

            TransactionController::insertToManager(Auth::user()->id,"+20","Made new recommendation","nope","nope","nope");

            Action::postAction('Recco new',Auth::user()->id,null,$recco->id);

            return 'success';
        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function loadRecco()
    {
        if (Auth::check())
        {
            $reccos = Recco::where('userid','!=',Auth::user()->id)->orderBy(Input::get('sort'),'DESC')->skip(Input::get('count'))->take(Input::get('count2'))->get();
            $moreReccos = Recco::where('userid','!=',Auth::user()->id)->orderBy(Input::get('sort'),'DESC')->skip(Input::get('count')+Input::get('count2'))->take(1)->get();
            return View::make('reccos')->with('reccos',$reccos)->with('moreReccos',count($moreReccos))->with('target','all')->with('count',Input::get('count'));
        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function loadMyRecco()
    {
        if (Auth::check())
        {
            $reccos = Recco::where('userid','=',Auth::user()->id)->orderBy(Input::get('sort'),'DESC')->skip(Input::get('count'))->take(Input::get('count2'))->get();
            $moreReccos = Recco::where('userid','=',Auth::user()->id)->orderBy(Input::get('sort'),'DESC')->skip(Input::get('count')+Input::get('count2'))->take(1)->get();
            return View::make('reccos')->with('reccos',$reccos)->with('moreReccos',count($moreReccos))->with('target','my')->with('count',Input::get('count'));
        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function incrementHits()
    {
        $recco = Recco::find(Input::get('id'));

        if ($recco->userid != Auth::user()->id)
        {
            $recco->hits++;
            $recco->save();

            $recco->user->profile->ifc++;
            $recco->user->profile->save();
        }
    }

    public function deleteRecco()
    {
        if (Auth::check())
        {
            $recco = Recco::find(Input::get('id'));
            $recco->delete();

            $reccos = Recco::where('userid','=',Auth::user()->id)->orderBy(Input::get('sort'),'DESC')->skip(0)->take(Input::get('count'))->get();
            $moreReccos = Recco::where('userid','=',Auth::user()->id)->orderBy(Input::get('sort'),'DESC')->skip(Input::get('count'))->take(1)->get();
            return View::make('reccos')->with('reccos',$reccos)->with('moreReccos',count($moreReccos))->with('target','my')->with('count',Input::get('count'));
        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function searchRecco()
    {
        if (Auth::check())
        {
        $users = Recco::all();
        $realUsers = User::all();
        $searchUsers=new \Illuminate\Database\Eloquent\Collection();
        foreach ($users as $user)
        {
            if(Str::contains(Str::lower($user->title),Str::lower(Input::get('keywords'))))
            {
                if (Input::get('category') == 'my')
                {
                    if ($user->userid == Auth::user()->id)
                        $searchUsers->add($user);
                }
                else
                    $searchUsers->add($user);
            }
        }

        foreach ($realUsers as $ru)
        {
            $name = $ru->first_name.' '.$ru->last_name;
            if(Str::contains(Str::lower($name),Str::lower(Input::get('keywords'))))
            {
                $reccos = $ru->recommendations()->get();
                foreach ($reccos as $user)
                {
                    if (!$searchUsers->contains($user))
                    {
                        $searchUsers->add($user);
                    }
                }
            }
        }

        $searchUsers = $searchUsers->sortByDesc(Input::get('sort'));
        return View::make('reccos')->with('reccos',$searchUsers)->with('moreReccos',0)->with('target','my')->with('count',0);
        }
        else
            return 'wH@tS!nTheB0x';
    }
}
