<?php

class SuggetsionController extends \BaseController {

	public function getWritingSuggestions()
    {
        if (Auth::check())
        {
            $suggestions=new \Illuminate\Database\Eloquent\Collection();
            $interests = Auth::user()->interestedIn()->get();
            foreach ($interests as $i)
            {
                $sugg = Suggestion::where('category','=',$i->id)->where('type','=',Input::get('request'))->get();

                foreach ($sugg as $s)
                    $suggestions->add($s);
            }
            $send = $suggestions->sortByDesc('created_at');

            return View::make('suggestionsList')->with('request',Input::get('request'))->with('suggestions',$send);
        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function postSuggestion()
    {
        if (Auth::check())
        {
            $suggestion = new Suggestion();
            $suggestion->text = Input::get('text');
            $suggestion->type = Input::get('type');
            $suggestion->category = Input::get('category');
            $suggestion->save();

            return 'success';
        }
        else
            return 'wH@tS!nTheB0x';
    }
}
