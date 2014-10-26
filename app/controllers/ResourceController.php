<?php

class ResourceController extends \BaseController
{

	public function getDashboard()
	{
		$user=Auth::user();
		$categories=Auth::user()->interestedIn()->get();
		$resources=$user->getResources()->orderBy('updated_at','DESC')->paginate(10);
		return View::make('resourceDashboard')->with('user',$user)->with('resources',$resources)->with('categories',$categories);
	}

	//this is the function to download a resource
	public function downloadResource($resourceId)
	{
		$resource = Resource::find($resourceId);
		$file = $resource->path;
		if($resource->userid!=Auth::user()->id)
		{
            $ifc = $resource->ifc;
            $owner = User::find($resource->userid);
            if (Friend::isFriend($owner->id) && $owner->settings->freeforfriends)
                return Response::download($file);

            if(Friend::isSubscriber($owner->id) && $owner->settings->discountforfollowers > 0)
            {
                $discount = ($ifc*$owner->settings->discountforfollowers)/100;
                $ifc = $ifc-$discount;
            }

            if (Auth::user()->profile->ifc > $ifc)
            {
				Auth::user()->profile->ifc-=$ifc;
				Auth::user()->profile->save();
				$resource->getAuthor->profile->ifc+=$ifc;
				$resource->getAuthor->profile->save();
                $resource->users ++;
                $resource->save();

                AjaxController::insertToNotification($resource->getAuthor->id,Auth::user()->id,"purchased","purchased your resource ".$resource->title,'http://b2.com/resource/'.$resource->id);

                TransactionController::insertToManager(Auth::user()->id,"-".$ifc,"Purchased resource",'http://b2.com/resource/'.$resource->id,$resource->title,"content");
                TransactionController::insertToManager($resource->getAuthor->id,"+".$ifc,"Resource purchased by",'http://b2.com/user/'.Auth::user()->username,Auth::user()->first_name.' '.Auth::user()->last_name,"profile");
            }
            else
                return View::make('ifcDeficit')->with('contentIFC',$ifc)->with('userIFC',Auth::user()->profile->ifc);
		}
		return Response::download($file);
	}

    public function getResource($resourceId)
    {
        $resource = Resource::find($resourceId);
        return View::make('resource')->with('resource',$resource);
    }

    public function getResourceIframe($resourceId)
    {
        $resource = Resource::find($resourceId);
        return View::make('resourceIframe')->with('resource',$resource);
    }

	//this is a function to delete a resource
	public function deleteResource()
	{
        if(Auth::check())
        {
		$resource = Resource::find(Input::get('id'));
		$resource->delete();
		File::delete($resource->path);
        Action::delAction(Input::get('id'));
	}
        else
            return 'wH@tS!nTheB0x';
    }
	//this is the function to create a new Resource

	public function createResource()
	{
        if(Auth::check())
        {
		//This is the time to create a user profile
		$resource=new Resource();
		$resource->userid=Auth::user()->id;
		//This is the code for storing the profile Tune
		//$name = Input::file('userMedia')->getClientOriginalName();
		$extension=Input::file('rFile')->getClientOriginalExtension();
		$fname=Str::words(Input::get('title'),1,'');
		$dt=new DateTime();
		$stamp=$dt->getTimestamp();
		$name=$stamp.$fname.'.'.$extension;
		$username=Auth::user()->username;
		Input::file('rFile')->move('Users/'.$username.'/Resources/', $name);
		//Set the path in database, allocate IFCs
		$filePath='Users/'.$username.'/Resources/'.$name;
		$resource->path=$filePath;
		$resource->title=Input::get('title');
        $resource->description=Input::get('description');
		$resource->ifc=Input::get('ifc');
		$resource->category=Input::get('category');
		$resource->type=$extension;
		$resource->save();

        Action::postAction('R new',Auth::user()->id,null,$resource->id);

		return $filePath;
	}
        else
            return 'wH@tS!nTheB0x';
    }
}

