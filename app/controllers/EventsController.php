<?php

class EventsController extends \BaseController
{
    public static $email=null;
    public static $name=null;

    public function getCreateEvent()
    {
        $categories=Auth::user()->interestedIn()->get();
        return View::make('createEvent')->with('categories',$categories);
    }

    public function postCreateEvent()
    {
        $event = new BEvent();
        $event->name = Input::get('title');
        $event->description = Input::get('description');
        $event->prerequesite = Input::get('prerequesite');
        $event->takeaway = Input::get('takeaway');
        $event->category = Input::get('category');
        $event->ifc = Input::get('ifc');
        $event->venue = Input::get('venue');
        $event->datetime = Input::get('datetime');
        $event->userid = Auth::user()->id;
        $event->save();

        Action::postAction('E new',Auth::user()->id,null,$event->id);
        $subscribers = DB::table('subscriptions')->where('subscribed_to_id','=',Auth::user()->id)->lists('subscriber_id');
        foreach($subscribers as $s)
        {
            EventsController::$email=User::find($s)->email;
            Mail::send('mailers',array('user' => User::find($s),'content' => $event,'type' => 'E','writer' => Auth::user(),'page'=>'readerMailer'),function($message)
            {
                $message->to(EventsController::$email)->subject('New Event');
            });
        }
        $cover = Input::file('uploadCover');
        $random_name = str_random(8);
        $destinationPath = "Users/".Auth::user()->username."/";
        $extension = $cover->getClientOriginalExtension();
        $filename='Event_'.$event->id.'_'.$random_name.'.'.$extension;
        Image::make(Input::file('uploadCover'))->resize(500, 500)->save($destinationPath.$filename);
        $event->cover = $destinationPath.$filename;
        $event->save();

        return Redirect::route('event',$event->id);
    }

    public function getEvent($id)
    {
        $event = BEvent::find($id);
        $attendees = $event->getGuestList()->get();
        $attendees = count($attendees);

        $currentTime = new DateTime();
        $eventTime = new DateTime($event->datetime);
        if ($eventTime > $currentTime)
            $registrations = true;
        else
            $registrations = false;

        return View::make('event')->with('event',$event)->with('attendees',$attendees)->with('registrations',$registrations);
    }

    public function eventRegister()
    {
        if(Auth::check())
        {
        Auth::user()->getAttendedEvents()->attach(Input::get('id'));
        DB::table('guest_list')->where('user_id',Auth::user()->id)->where('event_id',Input::get('id'))->update(array('contact_no' => Input::get('number')));

        $event = BEvent::find(Input::get('id'));
        $ifc = $event->ifc;
        $owner = User::find($event->userid);
        if (Friend::isFriend($owner->id) && $owner->settings->freeforfriends)
            return 'success';

        if(Friend::isSubscriber($owner->id) && $owner->settings->discountforfollowers > 0)
        {
            $discount = ($ifc*$owner->settings->discountforfollowers)/100;
            $ifc = $ifc-$discount;
        }
        Auth::user()->profile->ifc -= $ifc;
        Auth::user()->profile->save();
        User::find($event->userid)->profile->ifc += $ifc;
        User::find($event->userid)->profile->save();
        $event->users++;
        $event->save();

        $host = User::find($event->userid);
        EventsController::$email = $host->email;

        TransactionController::insertToManager(Auth::user()->id,"-".$ifc,"Registered to the event ",'http://b2.com/event/'.$event->id,$event->title,"content");
        TransactionController::insertToManager(User::find($event->userid)->id,"+".$ifc,"New attendee to the event '".$event->title."' :",'http://b2.com/user/'.Auth::user()->username,Auth::user()->first_name.' '.Auth::user()->last_name,"profile");

        AjaxController::insertToNotification($event->userid,Auth::user()->id,"purchased","Registered to your Event ".$event->title,'http://b2.com/event/'.$event->id);

        Mail::send('mailers', array('host'=>$host, 'attendee'=>Auth::user(), 'event'=>$event, 'contact'=>Input::get('number'),'page'=>'newAttendeeMailer'), function($message)
        {
            $message->to(EventsController::$email)->subject('New Attendee');
        });

        return 'success';
    }
        else
            return 'wH@tS!nTheB0x';
    }
    public function cancelRegister()
    {
        if(Auth::check())
        {
        DB::table('guest_list')->where('user_id',Auth::user()->id)->where('event_id',Input::get('id'))->delete();

        $event =BEvent::find(Input::get('id'));
        $event->users--;
        $event->save();
        $host = User::find($event->userid);
        EventsController::$email = $host->email;

        Mail::send('mailers', array('host'=>$host, 'attendee'=>Auth::user(), 'event'=>$event,'page'=>'attendeeCancellationMailer'), function($message)
        {
            $message->to(EventsController::$email)->subject('Attendee Cancellation!');
        });

        return 'success';
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function manageEvents()
    {
        $events = Auth::user()->getHostedEvents()->orderBy('created_at','DESC')->get();
        return View::make('manageEvents')->with('events',$events);
    }

    public function getAttendeeList($id)
    {
        if (Auth::user()->id == BEvent::find($id)->userid)
        {
            $attendees = BEvent::find($id)->getGuestList()->get();
            return View::make('attendeeList')->with('attendees',$attendees)->with('event',BEvent::find($id));
        }
        else
            return View::make('errorPage')->with('error','you don\t have access to this page')->with('link','http://b2.com/home');
    }

    public function getUpdateEvent($id)
    {
        if (Auth::user()->id == BEvent::find($id)->userid)
        {
            $event = BEvent::find($id);
            $categories=Auth::user()->interestedIn()->get();
            return View::make('updateEvent')->with('event',$event)->with('categories',$categories);
        }
        else
            return View::make('errorPage')->with('error','you don\t have access to this page')->with('link','http://b2.com/home');
    }

    public function postUpdateEvent()
    {
        $event = BEvent::find(Input::get('event-id'));
        $event->name = Input::get('title');
        $event->description = Input::get('description');
        $event->prerequesite = Input::get('prerequesite');
        $event->takeaway = Input::get('takeaway');
        $event->category = Input::get('category');
        $event->ifc = Input::get('ifc');
        $event->venue = Input::get('venue');
        $event->datetime = Input::get('datetime');
        $event->save();

        $cover = Input::file('uploadCover');
        if ($cover)
        {
            $random_name = str_random(8);
            $destinationPath = "Users/".Auth::user()->username."/";
            $extension = $cover->getClientOriginalExtension();
            $filename='Event_'.$event->id.'_'.$random_name.'.'.$extension;
            Image::make(Input::file('uploadCover'))->resize(500, 500)->save($destinationPath.$filename);
            $event->cover = $destinationPath.$filename;
        }
        $event->save();

        return Redirect::route('event',$event->id);
    }

    public function deleteEvent()
    {

        if(Auth::check())
        {

        $event=BEvent::find(Input::get('id'));
        File::delete($event->cover);
        $event->delete();

        Action::delAction(Input::get('id'));
        return 'success';
        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function toggleEvent()
    {
        if(Auth::check())
        {
        $event = BEvent::find(Input::get('id'));
        if ($event->open)
            $event->open = false;
        else
            $event->open = true;
        $event->save();
        return 'success';
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function myEvents()
    {
        $events = Auth::user()->getAttendedEvents()->get();
        return View::make('myEvents')->with('events',$events);
    }

    public function mailMe()
    {
        if(Auth::check())
        {
        $event = BEvent::find(Input::get('id'));
        $attendees = $event->getGuestList()->get();
        EventsController::$name = $event->name;
        Mail::send('mailers', array('attendees'=>$attendees, 'event'=>$event,'page'=>'attendeeListMailer'), function($message)
        {
            $message->to(Auth::user()->email)->subject('Guest List for "'.EventsController::$name.'"');
        });
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function showCategoryEvents()
    {
        if(Auth::check())
        {
        if (Input::get('interest') == 'all')
        {
            $events = BEvent::orderBy('datetime','DESC')->get();
            $moreEvents = BEvent::orderBy('datetime','DESC')->skip(Input::get('count')+4)->take(4)->get();
        }
        else
        {
            $events = BEvent::orderBy('datetime','DESC')->where('category','=',Input::get('interest'))->get();
            $moreEvents = BEvent::orderBy('datetime','DESC')->where('category','=',Input::get('interest'))->skip(Input::get('count')+4)->take(4)->get();
        }
        $count = count($moreEvents);

        $send = $events->filter(function($eve)
        {
            $currentTime = new DateTime();
            $eventTime = new DateTime($eve->datetime);
            if ($eventTime > $currentTime)
                return true;
        });

        $send = $send->sortByDesc('datetime')->slice(0,4);

        return View::make('categoryEvents')->with('events',$send)->with('count',$count)->with('intCount',Input::get('count'))->with('interest',Input::get('interest'))->with('index',Input::get('index'));
    }
        else
            return 'wH@tS!nTheB0x';
    }
}
