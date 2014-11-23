@if($page=='activationMailer')
    <!-- Mailer to verify the user who signed up recently -->
    <h3>Hi, {{$user->first_name}}</h3>
    <hr>
    <p></p><p>Thank you for registering.</p><p>
        You need to click on the link below to complete your registration.</p><p><a href="{{url('activate/'.Crypt::encrypt($user->id))}}" style="line-height: 1.42857143; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);">&nbsp;BBarters</a></p><p>
    </p><hr>
        Regards,<br>
        Team BBarters.
    <p></p>
@elseif($page=='forgotPasswordMailer')
    <h3>Hey there!</h3><hr>
    Looks like you just forgot your BBarters password.<br>
    No problem, here's your code:<div><br>
        <span class="col-lg-2 col-lg-offset-5 well" style="text-align: center">{{$link}}</span>
        <div><br></div><hr><div><br></div>

        Regards,<br>
        Team BBarters.
    </div>
@elseif($page=='bugMailer')
    <h3>Hello Admin,</h3>
    <hr>
    New Bug :(<br>
    <br>
    {{$bug->text}}&nbsp;<div>&nbsp;
    <br>Posted By:
    <a href="http://b2.com/user/{{User::find($bug->userid)->username}}" style="text-decoration: none">
        {{User::find($bug->userid)->first_name}} {{User::find($bug->userid)->last_name}}
    </a>
    <br>
    <br>
    <br>
    Respond to this bug HERE: http://b2.com/respondToBug/{{$bug->id}}
    <hr></div>
@elseif($page=='bugResponseMailer')
    <h3>Hey there!</h3>
    <hr>
    Our Admin just responded to the bug that you recently reported.<br>
    <br>
    "{{$response}}"<br>
    And with that, {{$ifc}} IFCs were credited to your account.<br>
    And yeah, a whole hearted thanks for your time.<br>
    <hr>
    Regards,<br>
    Team BBarters.
@elseif($page=='newSubmissionRequest')
    <h3> Hey There,</h3>
    <hr>

    <p>
        <a href="{{route('user',$user->username)}}" style="text-decoration: none">{{$user->first_name}} {{$user->last_name}}</a> just submitted
        @if ($review->type == 'article')
        an article for review.
        <br>
        <a href="{{route('reviewArticle',$content->id)}}" style="text-decoration: none" target="_blank">{{$content->title}}</a>
        @elseif ($review->type == 'book')
        a blogbook for review.
        <br>
        <a href="{{url('reviewBlogBook/'.$content->id)}}" style="text-decoration: none" target="_blank">{{$content->title}}</a>
        @endif
    </p>
    <hr>
    <p>Regards,<br>BBarters Team</p>
@elseif($page=='approveContributionMailer')
    <h3>Hi {{$collaborator->first_name}},</h3><hr>
    {{Auth::user()->first_name}} {{Auth::user()->last_name}} just contributed a new chapter called '{{$chapter->title}}' to your collaboration '{{$collaboration->title}}'. Click the following link to approve/decline.
    <span class="col-lg-2 col-lg-offset-5 well" style="text-align: center">
        <a href="{{route('contributionApprove',$chapter->id)}}">Click here.

        </a>
    </span>
    <div><br></div><hr><div><br></div>

    Regards,<br>
    Team BBarters.
@elseif($page=='collaborationInviteMailer')
    <h3>Hey There!</h3>
    <hr>
    {{Auth::user()->first_name}} {{Auth::user()->last_name}} has invited you
    to join and contribute for a collaboration called '{{$collaboration->title}}' on BBarters.<div><br></div><div>
        Click On the following link to accept.<br>
        <strong>Link: </strong> http://b2.com/acceptCollaboration/{{$invite->link}}/{{$invite->collaborationid}}
        <br>
        <hr>
        <br>
        Regards,<br>
        Team BBarters.
    </div>
@elseif($page=='joinAndCollaborateMailer')
    <h3>Hey There</h3>
    <hr>
    {{Auth::user()->first_name}} {{Auth::user()->last_name}} has invited you to join and contribute for a collaboration called '{{$collaboration->title}}' on BBarters.<div><br>
        It seems like you aren't already there on BBarters. No worries, click on the link below and get started! Once you are done, don't forget to come back and click the link at the bottom of this page to accept the collaboration.<br>
        Sign Up here: http://b2.com&nbsp;</div><div><br>
        And here's the link to accept the invitation. Remember, click this only when you've completed all SignUp and ProfileSetup steps, and you got to register with us using THIS E-mail only.<br>
        <strong><br></strong></div><div><strong>Link: </strong> http://b2.com/acceptCollaboration/{{$invite->link}}/{{$invite->collaborationid}}
        <br>
        <hr><br>
        Regards,<br>
        Team BBarters.
    </div>
@elseif($page=='newContributionRequestMailer')
    <h3>Hey {{User::find(Collaboration::find($collaborationId)->userid)->first_name}},</h3>
    <hr>
    {{User::find($userId)->first_name}} {{User::find($userId)->last_name}} just sent you a request to start
    contributing for '{{Collaboration::find($collaborationId)->title}}'.<br>
    <br>
    Here's what he wrote for you:<br>
    <i>"{{$reason}}"</i><br>
    You can find more about him by visiting his profile <a href="{{route('user',User::find($userId)->username)}}" style="text-decoration: none">HERE</a><br>
    <br>
    Finally, if you'd like to add him up as a contributor for your collaboration, don't forget to click the below button.<br>
    <br>
    <a href="{{route('acceptContributionRequest',$link)}}" style="text-decoration: none; padding: 5px; background-color: #003163; color: #ffffff">ACCEPT</a><br>
    <br>
    <hr>
    <br>
    Regards,<br>
    Team BBarters.
@elseif($page=='newAttendeeMailer')
    <h3>Hello {{$host->first_name}},</h3>
    <div>
        <hr>
    </div>
    <img src="{{asset($attendee->profile->profilePic)}}" height="40px" width="35px">
    <h4 style="font-family: 'Segoe UI'; color: rgb(51, 51, 51);">
        <span style="color: inherit; font-family: inherit; line-height: 1.1;">{{$attendee->first_name}} {{$attendee->last_name}} just registered for your event '{{$event->name}}' on BBarters. His contact number is {{$contact}} and you can mail @if($attendee->gender == 'male') him @else her @endif on {{$attendee->email}}. With that, your guest-list counts to <strong>{{$event->users}}</strong>.</span></h4>
    <h4 style="font-family: 'Segoe UI'; color: rgb(51, 51, 51);">Visit @if($attendee->gender == 'male') his @else her @endif profile <a href="{{route('user',$attendee->username)}}">here.</a></h4><div><br></div><div><h4 style="font-family: 'Segoe UI'; color: rgb(51, 51, 51);">You can view the entire list of attendees for this event <a href="{{route('attendeeList',$event->id)}}">here.</a></h4></div>
    <div>
        <hr>
    </div>
    <h4>Regards,<br>
        Team BBarters.
    </h4>
@elseif($page=='attendeeCancellationMailer')
    <h3>Hello {{$host->first_name}},</h3>
    <div>
        <hr>
    </div>
    <img src="{{asset($attendee->profile->profilePic)}}" height="40px" width="35px">
    <h4 style="font-family: 'Segoe UI'; color: rgb(51, 51, 51);">
        <span style="color: inherit; font-family: inherit; line-height: 1.1;">{{$attendee->first_name}} {{$attendee->last_name}} just dropped the idea of attending your event '{{$event->name}}'. With that, <strong>{{$event->users}}</strong> people are now attending your event.</span></h4><div><br></div><div><h4 style="font-family: 'Segoe UI'; color: rgb(51, 51, 51);">You can view the entire list of attendees for this event <a href="{{route('attendeeList',$event->id)}}">here.</a></h4></div>
    <div>
        <hr>
    </div>
    <h4>Regards,<br>
        Team BBarters.
    </h4>
@elseif($page=='attendeeListMailer')
    <!DOCTYPE html>
    <html>

    <head>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
        }
        th {
            text-align: left;
        }
    </style>
    </head>

    <body>

    Here's your list.<br>
    <br>
    <hr>

    <table style="width:100%">
        <tr>
            <th>Name</th>
            <th>E-mail</th>
            <th>Contact No.</th>
        </tr>
        @foreach($attendees as $a)
        <tr>
            <td>{{$a->first_name}} {{$a->last_name}}</td>
            <td>{{$a->email}}</td>
            <?php $number = DB::table('guest_list')->where('event_id',$event->id)->where('user_id',$a->id)->pluck('contact_no'); ?>
            <td>{{$number}}</td>
        </tr>
        @endforeach
    </table>

    <hr>
    <br><br>
    Regards,<br>
    Team BBarters.

    </body>
    </html>
@elseif($page=='newFriendRequestMailer')
    <h3>Hello {{$receiver->first_name}}</h3> <hr>

    <p><a href="http://b2.com/user/{{$user->username}}">{{$user->first_name}} {{$user->last_name}}</a> just sent you a friend request on BBarters!</p>
    <p>Visit <a href="http://b2.com">BBarters</a> and respond to his request.</p>
    <br>
    <hr>
    <p>Regards,<br>Team BBarters.</p>
@elseif($page=='friendRequestAcceptedMailer')
    <h3>Hello {{$receiver->first_name}}!</h3>
    <hr>
    <p><a href="http://b2.com/user/{{$user->username}}">{{$user->first_name}} {{$user->last_name}}</a> just accepted your friend request on BBarters!</p>
    <br>
    <hr>
    <p>Regards,<br>Team BBarters.</p>
@elseif($page=='newSubscriber')
    <h3>Hello {{$receiver->first_name}}!</h3>
    <hr>
    <p><a href="http://b2.com/user/{{$user->username}}">{{$user->first_name}} {{$user->last_name}}</a> has subscribed to you on BBarters!</p>
    <p>And that increments your IFC count by {{$receiver->settings->subcost}}<i>i</i>!</p>
    <hr>
    <p>Regards,<br>Team BBarters.</p>
@elseif($page=='newTransferMailer')
    <h3>Hello {{$receiver->first_name}}!</h3>
    <hr>
    <p>{{$user->first_name}} {{$user->last_name}} just transferred {{$ifc}} IFCs to your account on BBarters!</p>
    <p>Your updated IFC balance is: {{$receiver->profile->ifc}} <i>i</i>.</p>
    <br>
    <hr>
    <p>Regards,<br>Team BBarters.</p>
@elseif($page=='articleReviewed')
    <h3>
        Hello {{$user->first_name}},
    </h3>
    <hr>
    Your article, '{{$article->title}}' just got reviewed!
    <br>
    <br>
    This review earned you {{$review->ifc}} IFCs.
    <br>
    <br>
    Our editors have the following suggestions for you:
    <br>
    <br>
    "{{$review->suggestions}}"
    <hr>
    <p>
        Regards,
        <br>
        BBarters Team
    </p>
@elseif($page=='blogBookReviewed')
    <h3>
        Hello {{$user->first_name}},
    </h3>
    <hr>
    Your BlogBook, '{{$blogBook->title}}' just got reviewed!
    <br>
    <br>
    This review earned you {{$review->ifc}} IFCs.
    <br>
    <br>
    Our editors have the following suggestions for you:
    <br>
    <br>
    "{{$review->suggestions}}"
    <hr>
    <p>
        Regards,<br>
        BBarters Team
    </p>
@elseif($page=='newQuestionMailer')
    <h3>Hello {{$receiver->first_name}}</h3>
    <hr>
    <p>{{$user->first_name}} {{$user->last_name}} just asked you a question on BBarters!<br>
        Visit your profile and head to 'Answer' under 'Write', answer this question and earn {{$questionIFC}} <i>i</i>.</p>
    <div><br></div><hr>
    <p>Regards,<br>Team BBarters.</p>
@elseif($page=='newAnswerMailer')
    <h3>Hello {{$receiver->first_name}}</h3>
    <hr>
    <p>{{$user->first_name}} {{$user->last_name}} just answered your question on BBarters!</p>
    <p>Visit his profile and head to 'Ask' under 'Write' to view the answer.</p>
    <br>
    <hr>
    <br>
    <p>Regards,<br>Team BBarters.</p>
@elseif($page=='aboutMailer')
    <h3>Hello {{$receiver->first_name}},</h3>
    <div>
        <hr>
    </div>
    <img src="{{asset($user->profile->profilePic)}}" height="40px" width="35px">
    <h4 style="font-family: 'Segoe UI'; color: rgb(51, 51, 51);">
        <span style="color: inherit; font-family: inherit; line-height: 1.1;">{{$user->first_name}} {{$user->last_name}} just posted something about you on BBarters. Visit your profile to read and approve the post.</span>
    </h4>
    <h4 style="font-family: 'Segoe UI'; color: rgb(51, 51, 51);">
        <a href="http://b2.com/profile" target="_blank">Visit your profile</a>
    </h4>
    <div>
        <hr>
    </div>
    <h4>Regards,<br>
        Team BBarters.
    </h4>
@elseif($page=='approveEditContributionMailer')
    <h3>Hi {{$collaborator->first_name}},</h3><hr>
    {{Auth::user()->first_name}} {{Auth::user()->last_name}} just edited a chapter called '{{$chapter->title}}' in your collaboration '{{$collaboration->title}}'. Click the following link to approve/decline.
        <span class="col-lg-2 col-lg-offset-5 well" style="text-align: center">
            <a href="{{route('contributionEditApprove',$buffer->id)}}">Click here.

            </a>
        </span>
    <div><br></div><hr><div><br></div>

    Regards,<br>
    Team BBarters.
@elseif($page=='readerMailer')
    <h3>Hello {{$user->first_name}} {{$user->last_name}}!</h3>
    <hr>
    @if($type == 'C')
        @if ($user->id == $writer->id)
            <p>Your chapter for the Collaboration '{{$content->title}}'  was approved by the admin. </p>
            <p><a href="{{route('collaborationPreview',$content->id)}}">Click here</a> to check it out.</p>
        @else
            <p>A new chapter has been added to Collaboration '{{$content->title}}' by
                <a target='_blank' href="{{route('user',$writer->username)}}">{{$writer->first_name}} {{$writer->last_name}}</a> </p>
            <p><a href="{{route('collaborationPreview',$content->id)}}">Click here</a> to check it out.</p>
        @endif
    @elseif($type == 'A')
    <p>A new article has been added by
    <a target='_blank' href="{{route('user',$writer->username)}}">{{$writer->first_name}} {{$writer->last_name}}</a> </p>
    <br>
    <p style="font-size: 25px"><a href="{{route('articlePreview',$content->id)}}">{{$content->title}}</a></p>
    @elseif($type == 'B new')
    <p>A new BlogBook has been added by
    <a target='_blank' href="{{route('user',$writer->username)}}">{{$writer->first_name}} {{$writer->last_name}}</a> </p>
    <p style="font-size: 25px"><a href="{{route('blogBookPreview',$content->id)}}">{{$content->title}}</a></p>
    @elseif($type == 'B')
    <p>A new chapter has been added to BlogBook <strong>{{$content->title}}</strong> by
        <a target='_blank' href="{{route('user',$writer->username)}}">{{$writer->first_name}} {{$writer->last_name}}</a> </p>
    <p><a href="{{route('blogBookPreview',$content->id)}}"><h4>Click here</h4></a> to check it out.</p>
    @elseif($type == 'C new')
    <p>A new Collaboration has been added by
    <a target='_blank' href="{{route('user',$writer->username)}}">{{$writer->first_name}} {{$writer->last_name}}</a> </p>
    <p style="font-size: 25px"><a href="{{route('collaborationPreview',$content->id)}}">{{$content->title}}</a> </p>
    @elseif($type == 'M')
    <p>A new media file has been added by
    <a target='_blank' href="{{route('user',$writer->username)}}">{{$writer->first_name}} {{$writer->last_name}}</a> </p>
    <p><a href="{{route('mediaPreview',$content->id)}}">{{$content->title}}</a></p>
    @elseif($type == 'Q')
    <p>A new Quiz has been added by
    <a target='_blank' href="{{route('user',$writer->username)}}">{{$writer->first_name}} {{$writer->last_name}}</a> </p>
    <p><a href="{{route('quizPreview',$content->id)}}">{{$content->title}}</a></p>
    @elseif($type == 'R')
    <p>A new Resource has been uploaded by
    <a target='_blank' href="{{route('user',$writer->username)}}">{{$writer->first_name}} {{$writer->last_name}}</a> </p>
    <p><a href="{{route('resource',$content->id)}}">{{$content->title}}</a></p>
    @elseif($type == 'E')
    <p>A new Event has been added by
    <a target='_blank' href="{{route('user',$writer->username)}}">{{$writer->first_name}} {{$writer->last_name}}</a> </p>
    <p><a href="{{route('event',$content->id)}}">{{$content->title}}</a></p>
    @elseif($type == 'P')
    <p>A new Poll has been added by
    <a target='_blank' href="{{route('user',$writer->username)}}">{{$writer->first_name}} {{$writer->last_name}}</a> </p>
    <p style='font-size: 20px'><a href="{{route('poll',$content->id)}}">{{$content->question}}</a></p>

    @endif
    <br>
    <hr>
    <p>Regards,<br>Team BBarters.</p>
@elseif($page=='failedSearch')
    {{$user->first_name}} {{$user->last_name}} (ID: {{$user->id}}) encountered an error while searching for '{{{$keywords}}}'.
@elseif($page=='exception')
    {{$exception}}
@elseif($page=='submitProblemOnException')
    Tried doing:
    <br>
    {{$past}}
    <br>
    Result should have been:
    <br>
    {{$future}}
    <br>
    Link entered:
    <br>
    {{$present}}
    <br>
    User: <a href="{{route('user',Auth::user()->username)}}">{{Auth::user()->first_name}} {{Auth::user()->last_name}} (ID: {{Auth::user()->id}})</a>
    <br>
    <br>
    <a href="{{route('respondToProblem',Auth::user()->id)}}">Respond</a>
@elseif($page=='responseToProblem')
    Hello {{$user->first_name}},
    <br>
    <hr>
    <br>
    {{$response}}
    <br>
    And with that, {{$ifc}} ifcs have been credited to your account!
    <br><br><hr>
    Regards,<br>
    Team BBarters.
@elseif($page=='forgotUsernameMailer')
    <h3>Hi {{$user->first_name}},</h3><hr>
        You recently requested to retrieve your forgotten username, and here it is: <b>{{$user->username}}</b>
    <div><br></div><hr><div><br></div>

    Regards,<br>
    Team BBarters.
@endif