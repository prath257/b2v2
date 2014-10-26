@foreach ($ongoingChats as $oc)
    @if($oc->user1==Auth::user()->id)
        <?php $chatUser = User::find($oc->user2); ?>
    @elseif($oc->user2==Auth::user()->id)
        <?php $chatUser = User::find($oc->user1); ?>
    @endif
        <!-- markup -->
        <?php $unreadMessages = $oc->getChatData()->where('seen','=',false)->where('senderid','!=',Auth::user()->id)->get(); ?>
        @if (count($unreadMessages) > 0)
            <?php $class = 'success'; ?>
        @else
            <?php $class = 'info'; ?>
        @endif
        <div id="Chat{{$oc->id}}" class="alert alert-{{$class}} alert-dismissible chats" role="alert" style="cursor: pointer" onclick="openChat({{$oc->id}},'{{$chatUser->first_name}} {{$chatUser->last_name}}')">
          <button type="button" class="close" onclick="closeChat()"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          {{$chatUser->first_name}} {{$chatUser->last_name}}
        </div>
@endforeach

@if (count($ongoingChats) == 0)
    <h4 style="text-align: center">None.</h4>
@endif