
<ul style="list-style-type: none; padding: 0px">


@foreach($notify as $note)

  <li >



     <div class="col-lg-12" style="padding: 0px">

<a href="{{$note->link}}" target="_blank">

     <div class="col-lg-2" style="padding: 0px; text-align: center">



 <img src="{{User::find($note->cuserid)->profile->profilePic}}" style="width: 40px; height:40px">


     </div>

       <div class="col-lg-7" style="padding: 0px">
         <p>{{User::find($note->cuserid)->first_name}} {{User::find($note->cuserid)->last_name}} {{$note->message}}</p>
       </div>
</a>


         @if($note->type=='friendR')
         <div id="btns{{$note->id}}" class="pull-right col-lg-3">
           <button class="btn btn-success" onclick="acceptFriendR('{{$note->id}}','{{$note->cuserid}}')">Accept</button> <button class="btn btn-danger" onclick="declineFriendR('{{$note->id}}','{{$note->cuserid}}')">Decline</button>
         </div>

         @elseif($note->type=='chat')
         <?php $chat = Chat::find($note->chid);

            if(count($chat) > 0)
            {
            $currentTime = new DateTime();
                        $lastSeen = $chat->created_at;
                        $form = $currentTime->diff($lastSeen);
            }

         ?>
         @if(count($chat) > 0)
            @if($form->i>15 || $form->h>0 || $form->d>0 || $form->m>0 || $form->y>0 || $chat->status == 'ongoing' || $chat->status == 'completed')
                <small style="color: darkred">EXPIRED</small>
            @else
                <div id="btns{{$note->id}}" class="pull-right col-lg-3">
                     <button class="btn btn-success" onclick="acceptChatR('{{$note->id}}','{{$note->chid}}')">Accept</button> <button class="btn btn-danger" onclick="declineChatR('{{$note->id}}','{{$note->chid}}')">Decline</button>
                </div>
            @endif
         @endif

         @elseif($note->type=='chatAcc')
              <?php $chat = Chat::find($note->chid); ?>
           @if(count($chat) > 0)
              @if ($chat->status != 'completed')
              <?php
                  $currentTime = new DateTime();
                  $lastSeen = $chat->created_at;
                  $form = $currentTime->diff($lastSeen);
               ?>
                  @if($form->i>15 || $form->h>0 || $form->d>0 || $form->m>0 || $form->y>0)
                      <small style="color: darkred">EXPIRED</small>
                  @else
                <div id="btns{{$note->id}}" class="pull-right col-lg-3">
                              <button class="btn btn-success" onclick="startChatR('{{$note->chid}}')">Join chat</button>
                  </div>
                  @endif

              @endif
           @endif

         @elseif($note->type=='iContri')
                <?php $link = DB::table('invite_contributors')->where('collaborationid',$note->chid)->where('useremail',Auth::user()->email)->pluck('link'); ?>
                <div id="btns{{$note->id}}" class="pull-right col-lg-3">
                <a class="btn btn-success" href="http://b2.com/acceptCollaboration/{{$link}}/{{$note->chid}}" target="_blank">Accept</a>
                </div>

        @elseif($note->type=='reqContri')
            <?php $link = DB::table('requestcontribution')->where('collaboration_id',$note->chid)->where('user_id',$note->cuserid)->pluck('link'); ?>
            <div id="btns{{$note->id}}" class="pull-right col-lg-3">
            <a class="btn btn-success" href="http://b2.com/acceptContributionRequest/{{$link}}" target="_blank">Accept</a>
            </div>

         @endif

      </div>


  </li>
  <div class="col-lg-12">&nbsp;</div>

@endforeach

</ul>
