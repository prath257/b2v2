
<ul style="list-style-type: none; padding-left: 10px">


@foreach($notify as $note)

  <li >



     <div class="col-lg-12" style="padding: 0px">

<a href="{{$note->link}}" target="_blank">

     <div class="col-lg-2" >



 <img src="{{asset(User::find($note->cuserid)->profile->profilePic)}}" style="width: 40px; height:40px">


     </div>

       <div class="col-lg-8">
         <p>{{User::find($note->cuserid)->first_name}} {{User::find($note->cuserid)->last_name}} {{$note->message}}</p>
       </div>
</a>


         @if($note->type=='friendR')
         <div id="btns{{$note->id}}">
           <button class="btn btn-success" onclick="acceptFriendR('{{$note->id}}','{{$note->cuserid}}')">Accept</button> <button class="btn btn-danger" onclick="declineFriendR('{{$note->id}}','{{$note->cuserid}}')">Decline</button>
         </div>

         @elseif($note->type=='chat')
         <div id="btns{{$note->id}}">
         <button class="btn btn-success" onclick="acceptChatR('{{$note->id}}','{{$note->chid}}')">Accept</button> <button class="btn btn-danger" onclick="declineChatR('{{$note->id}}','{{$note->chid}}')">Decline</button>
         </div>

         @elseif($note->type=='chatAcc')
              <?php $chat = Chat::find($note->chid); ?>
              @if ($chat->status != 'completed')
              <div id="btns{{$note->id}}">
              <button class="btn btn-success" onclick="startChatR('{{$note->chid}}')">Join chat</button>
              </div>
              @endif

         @elseif($note->type=='iContri')
                <?php $link = DB::table('invite_contributors')->where('collaborationid',$note->chid)->where('useremail',Auth::user()->email)->pluck('link'); ?>
                <div id="btns{{$note->id}}">
                <a class="btn btn-success" href="http://localhost/b2v2/acceptCollaboration/{{$link}}/{{$note->chid}}" target="_blank">Accept</a>
                </div>

        @elseif($note->type=='reqContri')
            <?php $link = DB::table('requestcontribution')->where('collaboration_id',$note->chid)->where('user_id',$note->cuserid)->pluck('link'); ?>
            <div id="btns{{$note->id}}">
            <a class="btn btn-success" href="http://localhost/b2v2/acceptContributionRequest/{{$link}}" target="_blank">Accept</a>
            </div>

         @endif

      </div>


  </li>
  <div class="col-lg-12">&nbsp;</div>

@endforeach

</ul>
